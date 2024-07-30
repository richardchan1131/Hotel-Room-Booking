<?php

namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mockery\Exception;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Modules\Hotel\Models\HotelRoomBooking;
use Carbon\Carbon;

class PayrexxGateway extends BaseGateway
{
    public $id   = 'payrexx';
    public    $name = 'Payrexx Checkout';
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Payrexx Checkout?'),

            ],
            [
                'type'       => 'input',
                'id'         => 'name',
                'label'      => __('Custom Name'),
                'std'        => __("Payrexx Checkout"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'       => 'editor',
                'id'         => 'html',
                'label'      => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'input',
                'id'    => 'instance_name',
                'label' => __('Instance name'),
            ],
            [
                'type'  => 'input',
                'id'    => 'api_secret_key',
                'label' => __('Api secret key'),
                'desc'=>__('Url callback: ')."<b>".route('gateway.webhook',['gateway'=>$this->id])."</b>",
            ]
        ];
    }

    public function process(Request $request, $booking, $service = '')
    {
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
        $payment->save();

        $booking->status = $booking::UNPAID;
        $booking->payment_id = $payment->id;
        $booking->save();
        return $this->payment($booking, $request);
    }

    public function payment($booking,$request){



        $instanceName = $this->getOption('instance_name');
        $secret = $this->getOption('api_secret_key');
        $payrexx = new \Payrexx\Payrexx($instanceName, $secret);

        $gateway = new \Payrexx\Models\Request\Gateway();

// amount multiplied by 100
        $gateway->setAmount($booking->total * 100);

// currency ISO code
        $gateway->setCurrency(Str::upper(setting_item('currency_main')));

// VAT rate percentage (nullable)
        $gateway->setVatRate(null);

//Product SKU
        $gateway->setSku($booking->code);


//success and failed url in case that merchant redirects to payment site instead of using the modal view
        $gateway->setSuccessRedirectUrl($this->getReturnUrl() . '?c=' . $booking->code);
        $gateway->setFailedRedirectUrl($this->getCancelUrl() . '?c=' . $booking->code);

        // optional: payment service provider(s) to use (see http://developers.payrexx.com/docs/miscellaneous)
        // empty array = all available psps
        $gateway->setPsp(array());
//            $gateway->setPm(array('visa'));

        // optional: if you want to do a pre authorization which should be charged on first time
//        $gateway->setChargeOnAuthorization(false);
        $gateway->setPreAuthorization(false);


        $gateway->setReservation(false);


        // subscription information if you want the customer to authorize a recurring payment.
        // this does not work in combination with pre-authorization payments.
        //$gateway->setSubscriptionState(true);
        //$gateway->setSubscriptionInterval('P1M');
        //$gateway->setSubscriptionPeriod('P1Y');
        //$gateway->setSubscriptionCancellationInterval('P3M');

        $desc = [];
        $desc[]= [
            'name' => [$booking->service->title],
            'quantity' => 1,
            'amount' => $booking->pay_now  * 100
        ];

        $gateway->setBasket($desc);

        // optional: reference id of merchant (e. g. order number)
        $gateway->setReferenceId($booking->code);

        // optional: add contact information which should be stored along with payment
        $gateway->addField($type = 'title', $value = setting_item('site_title'));
        $gateway->addField($type = 'forename', $value = $request->last_name);
        $gateway->addField($type = 'surname', $value = $request->first_name);
        $gateway->addField($type = 'company', $value = $request->first_name);
        $gateway->addField($type = 'street', $value = $request->address);
        $gateway->addField($type = 'postcode', $value = $request->zip_code);
        $gateway->addField($type = 'place', $value = $request->state);
        $gateway->addField($type = 'country', $value = $request->country);
        $gateway->addField($type = 'phone', $value = $request->phone);
        $gateway->addField($type = 'email', $value = $request->email);
        $gateway->addField($type = 'description', $value = $request->email);
//        $gateway->setButtonText(
//            ['Fortfahren','Fortfahren','Continue']
//        );
//        $gateway->addField($type = 'terms', $value='asdasdasd');
//        $gateway->addField($type = 'privacy_policy', $value='23123123123');
        try {
            $response = $payrexx->create($gateway);
            if(!empty($response->getLink())){
                $booking->addMeta('payrexxId',$response->getId());
                response()->json([
                    'url' => $response->getLink()
                ])->send();
            }
        } catch (\Payrexx\PayrexxException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function handlePurchaseData($data, $booking, $request)
    {
        $payrexx_args = array();
        $payrexx_args['sid'] = $this->getOption('payrexx_account_number');
        $payrexx_args['paypal_direct'] = 'Y';
        $payrexx_args['cart_order_id'] = $booking->code;
        $payrexx_args['merchant_order_id'] = $booking->code;
        $payrexx_args['total'] = (float) $booking->pay_now;
        $payrexx_args['return_url'] = $this->getCancelUrl().'?c='.$booking->code;
        $payrexx_args['x_receipt_link_url'] = $this->getReturnUrl().'?c='.$booking->code;
        $payrexx_args['currency_code'] = setting_item('currency_main');
        $payrexx_args['card_holder_name'] = $request->input("first_name").' '.$request->input("last_name");
        $payrexx_args['street_address'] = $request->input("address_line_1");
        $payrexx_args['street_address2'] = $request->input("address_line_1");
        $payrexx_args['city'] = $request->input("city");
        $payrexx_args['state'] = $request->input("state");
        $payrexx_args['country'] = $request->input("country");
        $payrexx_args['zip'] = $request->input("zip_code");
        $payrexx_args['phone'] = "";
        $payrexx_args['email'] = $request->input("email");
        $payrexx_args['lang'] = app()->getLocale();
        return $payrexx_args;
    }

    public function getDisplayHtml()
    {
        $location = app()->getLocale();
        if (setting_item('site_locale') == $location){
            return $this->getOption('html', '');
        } else {
            return $this->getOption('html_'.$location);
        }
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and  !in_array($booking->payment_status, [
                $booking::PAID,
                $booking::COMPLETED,
                $booking::CANCELLED])) {
            $checkPayment = $this->checkPayment($booking);
            $status  = $checkPayment->getStatus();
            if ($status != 'confirmed') {
                $payment = $booking->payment;
                if ($payment) {
                    $data = $checkPayment->toArray($checkPayment);
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($data);
                    $payment->save();
                }
                try {
                    if($status =='waiting'){
                            $booking->markAsProcessing($booking,[]);
                        return redirect($booking->getDetailUrl())->with("error", __("Your payment has been placed"));
                    }else{
                        $booking->markAsPaymentFailed();
                    }
                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
            } else {
                $payment = $booking->payment;
                if ($payment) {
                    $data = $checkPayment->toArray($checkPayment);
                    $payment->status = 'completed';
                    $payment->logs = \GuzzleHttp\json_encode($data);
                    $payment->save();
                }
                try {
                    $booking->paid += (float) $booking->pay_now;
                    $booking->markAsPaid(Booking::CONFIRMED);

                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                return redirect($booking->getDetailUrl())->with("success", __("You payment has been processed successfully"));
            }
        }
        if (!empty($booking)) {
            return redirect($booking->getDetailUrl(false));
        } else {
            return redirect(url('/'));
        }
    }
    public function callbackPayment(Request $request)
    {
        $transaction = $request->transaction;
        if(!empty($transaction['referenceId'])){
            $booking = Booking::where('code', $transaction['referenceId'])->first();
            if (!empty($booking) and !in_array($booking->payment_status, [
                    $booking::PAID,
                    $booking::COMPLETED,
                    $booking::CANCELLED])) {

                $checkPayment = $this->checkPayment($booking,$transaction);
                $status  = $checkPayment->getStatus();
                $amount = $checkPayment->getAmount();
                if ($status != 'confirmed') {
                    $payment = $booking->payment;
                    if ($payment) {
                        $data = $checkPayment->toArray($checkPayment);
                        $payment->status = 'fail';
                        $payment->logs = \GuzzleHttp\json_encode($data);
                        $payment->save();
                    }
                    try {
                        if($status =='waiting'){
                            $booking->markAsProcessing($booking,[]);
                            return response()->json(['status'=>'error',"message"=> __("Payment Processing")]);
                        }elseif ($status=='authorized'){
                                $booking->markAsProcessing($payment, []);
                            return response()->json(['status'=>'error',"message"=> __("Payment Processing")]);
                        }else {
                            $booking->markAsPaymentFailed();
                            return response()->json(['status'=>'error',"message"=> __("Payment Failed.")]);
                        }
                    } catch (\Swift_TransportException $e) {
                        return response()->json(['status'=>'error',"message"=> __("Payment Failed")]);
                    }
                } else {
                    $payment = $booking->payment;
                    if ($payment) {
                        $data = $checkPayment->toArray($checkPayment);
                        $payment->status = 'completed';
                        $payment->logs = \GuzzleHttp\json_encode($data);
                        $payment->save();
                    }
                    try {
                        $booking->paid += (float) ($amount/100);
                        $booking->markAsPaid();


                    } catch (\Swift_TransportException $e) {
                        return response()->json(['status'=>'error',"message"=> $e->getMessage()]);
                    }

                    return response()->json(['status'=>'success',"message"=> __("You payment has been processed successfully before")]);
                }
            }
            if (!empty($booking)) {
                return response()->json(['status'=>'success',"message"=> __("No information found")]);
            } else {
                return response()->json(['status'=>'error',"message"=> __("No information found")]);
            }
        }else{
            return response()->json(['status'=>'error',"message"=> __("referenceId can't null")]);
        }

    }


    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();
        if (!empty($booking) and in_array($booking->status, [Booking::DRAFT])) {
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = \GuzzleHttp\json_encode([
                    'customer_cancel' => 1
                ]);
                $payment->save();
            }
            return redirect()->to(route('booking.cancel'))->with("error", __("You cancelled the payment"));
        }
        return redirect()->to(route('booking.cancel'));
    }

    public function checkPayment($booking,$transaction=false){
        $payrexxId = $booking->getMeta('payrexxId');
        $instanceName = $this->getOption('instance_name');
        $secret = $this->getOption('api_secret_key');
        $payrexx = new \Payrexx\Payrexx($instanceName, $secret);
        $gateway = new \Payrexx\Models\Request\Gateway();


        if(!empty($transaction['id'])){
            //For webhooks
            $transition = new \Payrexx\Models\Request\Transaction();
            $transition->setId($transaction['id']);
            try {
                $response = $payrexx->getOne($transition);

                if(!empty($response->getStatus())){
                    return $response;
                }
            } catch (\Payrexx\PayrexxException $e) {
                print $e->getMessage();
            }

        }else{
            // Khong the capture dc gateway o day,
            $gateway->setId($payrexxId);
            try {
                $response = $payrexx->getOne($gateway);

                if(!empty($response->getStatus())){
                    return $response;
                }
            } catch (\Payrexx\PayrexxException $e) {
                print $e->getMessage();
            }
        }

    }
    public function getDisplayLogo()
    {
        $logo_id = $this->getOption('logo_id');
        return get_file_url($logo_id,'medium');
    }

}
