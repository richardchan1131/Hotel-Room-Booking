<?php


namespace Modules\Booking\Gateways;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Gateways\BaseGateway;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;

class StripeCheckoutGateway extends BaseGateway
{
    protected $id = 'stripe_checkout';

    public $name = 'Stripe Checkout V2';

    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Stripe Checkout V2?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Stripe"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_secret_key',
                'label'     => __('Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_publishable_key',
                'label'     => __('Publishable Key'),
            ],
            [
                'type'       => 'checkbox',
                'id'        => 'stripe_enable_sandbox',
                'label'     => __('Enable Sandbox Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_secret_key',
                'label'     => __('Test Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_publishable_key',
                'label'     => __('Test Publishable Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'endpoint_secret',
                'label'     => __('Webhook Secret'),
                'desc'     => __('Webhook url: <code>:code</code>',['code'=>$this->getWebhookUrl()]),
            ]
        ];
    }


    public function process(Request $request, $booking, $service)
    {
        $this->setupStripe();

        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {

            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->pay_now) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $payment->amount = (float) $booking->pay_now;

        $stripe_customer_id =  $this->tryCreateUser($booking);
        $session_data = [
            'mode' => 'payment',
            'customer' => $stripe_customer_id,
            'success_url' => $this->getReturnUrl() . '?c=' . $booking->code.'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->getCancelUrl() . '?c=' . $booking->code,
            'line_items'=>[
                [
                    'price_data'=>[
                        'currency'=>setting_item('currency_main'),
                        'product_data'=>[
                            'name'=>$booking->service->title ?? '',
                            'images'=>[get_file_url($booking->service->image_id ?? '')]
                        ],
                        'unit_amount'=>(float) $booking->pay_now * 100
                    ],
                    'quantity'=>1
                ]
            ]
        ];
        if(empty($session_data['line_items'][0]['price_data']['product_data']['images'][0])){
            unset($session_data['line_items'][0]['price_data']['product_data']['images']);
        }

        if(empty($session_data['customer'])){
            unset($session_data['customer']);
        }
        $session = \Stripe\Checkout\Session::create($session_data);
        $payment->addMeta('stripe_session_id',$session->id);

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();

        try{
            event(new BookingCreatedEvent($booking));
        } catch(\Swift_TransportException $e){
            Log::warning($e->getMessage());
        }

        $booking->addMeta('stripe_session_id',$session->id);


        return response()->json(['url'=>$session->url ?? $booking->getDetailUrl()])->send();
    }

    public function tryCreateUser(Booking $booking){

        $user = auth()->user();
        if($user and $user->stripe_customer_id){
            return $user->stripe_customer_id;
        }

        try {
            $customer = \Stripe\Customer::create([
                'address'=>$booking->address,
                'email'=>$booking->email,
                'phone'=>$booking->phone,
                'name'=>$booking->first_name.' '.$booking->last_name,
            ]);
        }catch (\Exception $e){

        }

        if(!empty($customer->id)){
            if($user) {
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }
            return $customer->id;
        }
        return null;


    }

    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = \GuzzleHttp\json_encode([
                    'customer_cancel' => 1
                ]);
                $payment->save();
            }

            // Refund without check status
            $booking->tryRefundToWallet(false);

            return redirect($booking->getDetailUrl())->with("error", __("You cancelled the payment"));
        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl());
        } else {
            return redirect(url('/'));
        }
    }

    public function setupStripe(){
        \Stripe\Stripe::setApiKey($this->getSecretKey());
    }

    public function getPublicKey(){
        if($this->getOption('stripe_enable_sandbox'))
        {
            return $this->getOption('stripe_test_publishable_key');
        }
        return $this->getOption('stripe_public_key');
    }

    public function getSecretKey(){
        if($this->getOption('stripe_enable_sandbox'))
        {
            return $this->getOption('stripe_test_secret_key');
        }
        return $this->getOption('stripe_secret_key');
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        $this->setupStripe();
        $session_id = $request->query('session_id');

        $session = \Stripe\Checkout\Session::retrieve($session_id);
        if(empty($session)){
            return redirect($booking->getDetailUrl(false));
        }

        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {

            $session_id = $request->query('session_id');
            if(empty($session_id)){
                return redirect($booking->getDetailUrl(false));
            }

            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if(empty($session)){
                return redirect($booking->getDetailUrl(false));
            }

            if($session->payment_status == 'paid'){
                $booking->paid += (float)$booking->pay_now;
                $booking->markAsPaid();
                $booking->addMeta('session_data',$session);
                $booking->addMeta('stripe_setup_intent',$session->setup_intent);
                $booking->addMeta('stripe_cs_complete',1);
            }
            if($session->payment_status == 'no_payment_required'){
                $booking->pay_now = 0;
                $booking->save();
                $booking->addMeta('session_data',$session);
                $booking->addMeta('stripe_setup_intent',$session->setup_intent);
                $booking->addMeta('stripe_cs_complete',1);

            }

            return redirect($booking->getDetailUrl(false));

        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl(false));
        } else {
            return redirect(url('/'));
        }
    }

    public function callbackPayment(Request $request){
        return $this->callback($request);
    }
    public function callback(Request $request)
    {
        $this->setupStripe();
        $endpoint_secret = $this->getOption('endpoint_secret');
        $payload = @file_get_contents('php://input');
        $event = NULL;

        if ($endpoint_secret and !empty($sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'])) {
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                return response()->json(['message' => __('Webhook error while validating signature.')], 400);
            }
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                $payment = Payment::whereHas('meta', function ($query) use($paymentIntent){
                    $query->where('stripe_intent_id',$paymentIntent->id);
                })->first();
                if (!$payment) {
                    return response()->json(['message' => __('Payment not found')], 400);
                }
                $booking = $payment->booking;
                if ($booking) {
                    $booking->paid += (float)$paymentIntent->amount / 100;
                    $booking->markAsPaid();

                }
                if (!empty($paymentIntent->charges->data)) {
                    $chargeArr= [];
                    foreach ($paymentIntent->charges->data as $charge) {
                        if ($charge['paid'] == true) {
                            $chargeArr[]=  $charge['id'];
                        }
                    }
                    if(!empty($chargeArr)){
                        $payment->addMeta('stripe_charge_id',$chargeArr);
                    }
                }
                $payment->status = 'completed';
                $payment->logs = \GuzzleHttp\json_encode($paymentIntent);
                $payment->save();
                break;
            default:
                return response()->json(['message' => __('Received unknown event type')], 400);
        }
    }

    public function processNormal($payment)
    {
        $this->setupStripe();
        $session = \Stripe\Checkout\Session::create([
            'mode'        => 'payment',
            'success_url' => $this->getReturnUrl(true).'?pid='.$payment->code.'&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => $this->getCancelUrl(true).'?pid='.$payment->code,
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'    => setting_item('currency_main'),
                        'unit_amount' => (float) $payment->amount * 100,
                        'product_data'=>[
                            'name'=>__("Buy credits"),
                        ],
                    ],

                    'quantity'   => 1
                ],
            ]
        ]);
        $payment->addMeta('stripe_session_id',$session->id);
        if (!empty($session->url)) {
            return [true, false, $session->url];
        }
        return [true];
    }
    public function confirmNormalPayment()
    {
        /**
         * @var Payment $payment
         */
        $request = \request();
        $c = $request->query('pid');
        $payment = Payment::where('code', $c)->first();


        if (!empty($payment) and in_array($payment->status, ['draft'])) {
            $this->setupStripe();
            $session_id = $request->query('session_id');
            if (empty($session_id)) {
                return [false];
            }
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if (empty($session)) {
                return [false];
            }
            if ($session->payment_status == 'paid') {
                return $payment->markAsCompleted($session);
            } else {
                return $payment->markAsFailed($session);
            }
        }
        if ($payment) {
            if ($payment->status == 'cancel') {
                return [false, __("Your payment has been canceled")];
            }
        }
        return [false];
    }



}
