<?php

namespace Modules\Booking\Gateways;

use App\Currency;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Omnipay\Omnipay;
use Omnipay\PayPal\ExpressGateway;
use Illuminate\Support\Facades\Log;
use Unicodeveloper\Paystack\Paystack;

class PaystackGateway extends BaseGateway
{
    public $name = 'Paystack Checkout';
    /**
     * @var $gateway Paystack
     */
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Paystack gateway?')
            ],
            [
                'type'       => 'input',
                'id'         => 'name',
                'label'      => __('Custom Name'),
                'std'        => __("Paystack"),
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
                'id'    => 'public_key',
                'label' => __('Public key')
            ],
            [
                'type'  => 'input',
                'id'    => 'secret_key',
                'label' => __('Secret key')
            ],
            [
                'type'  => 'input',
                'id'    => 'payment_url',
                'label' => __('Payment Url'),
                'std'   => "https://api.paystack.co"
            ],
            [
                'type'  => 'input',
                'id'    => 'merchant_email',
                'label' => __('Merchant Email'),
                'desc'  => "Url Callback: <b>" . route('booking.confirm-payment', ['gateway' => $this->id]) . "</b> <br>Url Webhook: <b>" . route('gateway.webhook', ['gateway' => $this->id]) . "</b> <br>",

            ],

        ];
    }

    public function process(Request $request, $booking, $service)
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

        $this->getGateway();
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';

        $data = $this->handlePurchaseData([], $booking, $payment);
        $response = $this->gateway->getAuthorizationResponse($data);

        if (!empty($response['status'] and !empty($response['data']['authorization_url']))) {
            $payment->save();
            $booking->status = $booking::UNPAID;
            $booking->payment_id = $payment->id;
            $booking->save();
            try {
                event(new BookingCreatedEvent($booking));
            } catch (\Exception $e) {
                Log::warning($e->getMessage());
            }
            // redirect to offsite payment gateway
            response()->json([
                'url' => $response['data']['authorization_url']
            ])->send();
        }
        else {
            throw new Exception('Paystack Gateway: ' . $response->getMessage());
        }
    }

    public function confirmPayment(Request $request)
    {
        $this->getGateway();
        $response = $this->gateway->getPaymentData();
        if ($response['status']) {
            $metadata = $response['data']['metadata'];
            if (!empty($metadata['normal_checkout']) and $metadata['normal_checkout']=='1') {
//                redirect to confirm normal
                return redirect(url($metadata['returnUrl'], $request->all()));
            }
            else {
                $booking = Booking::where('code', $metadata['code'])->first();
                if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {

                    if (!empty($response['status']) and $response['data']['status'] == 'success') {
                        $payment = $booking->payment;
                        if ($payment) {
                            $payment->status = 'completed';
                            $payment->logs = \GuzzleHttp\json_encode($response);
                            $payment->save();
                        }
                        try {
                            $booking->paid += (float)$booking->pay_now;
                            $booking->markAsPaid();

                        } catch (\Exception $e) {
                            Log::warning($e->getMessage());
                        }
                        return redirect($booking->getDetailUrl())->with("success", __("You payment has been processed successfully"));
                    }
                    else {
                        $payment = $booking->payment;
                        if ($payment) {
                            $payment->status = 'fail';
                            $payment->logs = \GuzzleHttp\json_encode($response);
                            $payment->save();
                        }
                        try {
                            $booking->markAsPaymentFailed();

                        } catch (\Exception $e) {
                            Log::warning($e->getMessage());
                        }
                        return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
                    }
                }
                if (!empty($booking)) {
                    return redirect($booking->getDetailUrl(false));
                }
            }
        }
        return redirect(url('/'));


    }

    /**
     * @var Payment $payment
     */
    public function confirmNormalPayment()
    {
        $this->getGateway();
        $response = $this->gateway->getPaymentData();
        if ($response['status']) {
            $metadata = $response['data']['metadata'];
            if ($metadata['code']) {
                $payment = Payment::where('code', $metadata['code'])->first();
                if (!empty($payment) and in_array($payment->status, ['draft'])) {
                    if ($response['status'] == 'success') {
                        return $payment->markAsCompleted(\GuzzleHttp\json_encode($response));
                    }
                    else {
                        return $payment->markAsFailed(\GuzzleHttp\json_encode($response));
                    }
                }
                else {
                    if ($payment->status == 'cancel') {
                        return [false, __("Your payment has been canceled")];
                    }
                }
            }
        }
        return [false];
    }


    public function processNormal($payment)
    {
        $this->getGateway();
        $payment->payment_gateway = $this->id;
        $data = $this->handlePurchaseDataNormal([], $payment);
        $response = $this->gateway->getAuthorizationResponse($data);
        if (!empty($response['status'] and !empty($response['data']['authorization_url']))) {
            return [true, false, $response['data']['authorization_url']];
        }
        else {
            return [false, $response->getMessage()];
        }
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
        }
        else {
            return redirect(url('/'));
        }
    }


    public function callbackPayment(Request $request)
    {
        try {
            $this->getGateway();
            $response = $this->gateway->getPaymentData();
            if (!empty($response['data']) and !empty($response['data']['metadata'])) {
                $metadata = $response['data']['metadata'];
                if (!empty($metadata['normal_checkout']) and $metadata['normal_checkout']=='1') {
                    $booking = Booking::where('code', $metadata['code'])->first();
                    if (!empty($booking) and !in_array($booking->status, [
                            $booking::PAID,
                            $booking::COMPLETED,
                            $booking::CANCELLED
                        ])) {
                        if (in_array($response['event'], ['charge.success', 'paymentrequest.success'])) {
                            $payment = $booking->payment;
                            if ($payment) {
                                $payment->status = 'completed';
                                $payment->logs = \GuzzleHttp\json_encode($response);
                                $payment->save();
                            }
                            try {
                                $booking->paid += (float)($response['data']['amount'] / 100);
                                $booking->markAsPaid();

                            } catch (\Exception $e) {
                                return response()->json(['status' => 'error', "message" => $e->getMessage()]);
                            }

                            return response()->json(['status' => 'success', "message" => __("You payment has been processed successfully before")]);
                        }
                    }
                    if (!empty($booking)) {
                        return response()->json(['status' => 'success', "message" => __("not update status " . $response['event'])]);
                    }
                    else {
                        return response()->json(['status' => 'error', "message" => __("No information found")]);
                    }
                }
                else {
                    $payment = Payment::where('code', $metadata['code'])->first();
                    if (!empty($booking) and !in_array($payment->status, [
                            $booking::PAID,
                            $booking::COMPLETED,
                            $booking::CANCELLED
                        ])) {
                        if (in_array($response['event'], ['charge.success', 'paymentrequest.success'])) {
                            try {
                                $payment->markAsCompleted(\GuzzleHttp\json_encode($response));
                                return response()->json(['status' => 'success', "message" => __("You payment has been processed successfully")]);
                            } catch (\Exception $e) {
                                return response()->json(['status' => 'error', "message" => $e->getMessage()]);
                            }
                        }
                        else {
                            return response()->json(['status' => 'success', "message" => __("You payment has been processed successfully before")]);
                        }
                    }

                }

            }


        } catch (\Exception $exception) {

        }

    }

    public function getGateway()
    {
        config()->set('paystack.publicKey', $this->getOption('public_key'));
        config()->set('paystack.secretKey', $this->getOption('secret_key'));
        config()->set('paystack.paymentUrl', $this->getOption('payment_url'));
        config()->set('paystack.merchantEmail', $this->getOption('merchant_email'));
        $this->gateway = (new Paystack());
    }

    public function handlePurchaseDataNormal($data, &$payment = null)
    {
        $main_currency = setting_item('currency_main');
        $data['amount'] = (float)$payment->amount * 100;
        $data['orderID'] = $payment->id;
        $data['reference'] = $payment->code . time();
        $data['email'] = $payment->email;
        $data['currency'] = \Str::upper($main_currency);
        $data['metadata'] = [
            'code'            => $payment->code,
            "cancel_action"   => $this->getCancelUrl(true) . '?pid=' . $payment->code,
            'normal_checkout' => 1,
            'returnUrl'       => $this->getReturnUrl(true) . '?pid=' . $payment->code,
            'cancelUrl'       => $this->getCancelUrl(true) . '?pid=' . $payment->code,

        ];
        return $data;
    }

    public function handlePurchaseData($data, $booking, &$payment = null)
    {
        $main_currency = setting_item('currency_main');
        $data['amount'] = (float)$booking->pay_now * 100;
        $data['orderID'] = $booking->id;
        $data['reference'] = $booking->code . time();
        $data['email'] = $booking->email;
        $data['currency'] = \Str::upper($main_currency);
        $data['returnUrl'] = $this->getReturnUrl() . '?c=' . $booking->code;
        $data['metadata'] = [
            'code'            => $booking->code,
            "cancel_action"   => $this->getCancelUrl() . '?c=' . $booking->code,
            'returnUrl'       => $this->getReturnUrl() . '?c=' . $booking->code,
            'cancelUrl'       => $this->getCancelUrl() . '?c=' . $booking->code,
            'normal_checkout' => 0
        ];
        return $data;
    }
}
