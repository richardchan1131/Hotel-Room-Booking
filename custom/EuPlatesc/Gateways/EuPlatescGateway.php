<?php

namespace Custom\EuPlatesc\gateways;

use App\Currency;
use Custom\EuPlatesc\App\Models\VendorEuPlatesc;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Omnipay\Omnipay;
use Omnipay\PayPal\ExpressGateway;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Booking\Gateways\BaseGateway;
use Modules\Hotel\Models\Hotel;

class EuPlatescGateway extends BaseGateway
{
    public $name = 'EuPlatesc Checkout';
    /**
     * @var $gateway ExpressGateway
     */
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Euplatesc Payment?')
            ],
            [
                'type'       => 'input',
                'id'         => 'name',
                'label'      => __('Custom Name'),
                'std'        => __("EuPlatesc"),
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
            ]
            // [
            //     'type'       => 'input',
            //     'input_type' => 'number',
            //     'id'         => 'exchange_rate',
            //     'label'      => __('Exchange Rate'),
            //     'desc'       => __('Example: Main currency is VND (which does not support by PayPal), you may want to convert it to USD when customer checkout, so the exchange rate must be 23400 (1 USD ~ 23400 VND)'),
            // ],
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        $EuPlatescData = VendorEuPlatesc::where('vendor_id', $booking->vendor_id)->first();

        if (!$EuPlatescData) {
            throw new Exception('EuPlatesc Gateway: This vendor didn`t set any credetentials for EuPlatesc. Please contact them!');
        }

        if ($EuPlatescData->active == 0)
            throw new Exception('Vendor hasn\'t enabled EuPlatesc payments!');

        $url = "https://secure.euplatesc.ro/tdsprocess/tranzactd.php";
        $mid = $EuPlatescData->mid;
        $key = $EuPlatescData->key;


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
        $hotel = Hotel::where('id', $booking->object_id)->first();

        $data = array(
            'amount'      => $booking->pay_now,
            // 'amount'      => '1.00',
            'curr'        => 'RON',
            'invoice_id'  => 'Payment #' . $payment->id,
            'order_desc'  => 'Plata cazare ' . $hotel->title . ' in perioada ' . date('Y.m.d', strtotime($booking->start_date)) . ' - ' . date('Y.m.d', strtotime($booking->end_date)) . ' code:' . $booking->code,
            'merch_id'    => $mid,
            'timestamp'   => date('YmdHis'),
            'nonce'       => md5(mt_rand() . time()),
        );
        $data['fp_hash'] = strtoupper($this->euplatesc_mac($data, $key));
        $data['email'] = 'test@euplatesc.ro';
        $data['fname'] = 'test';
        $data['ExtraData[silenturl]'] = url('/gateway/confirm/EuPlatesc');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $returnUrl = Str::after($response, 'URL=');
        $returnUrl = Str::before($returnUrl, "'>");
        Log::info('send data ' . json_encode($data));
        return response()->json([
            'url' => $returnUrl
        ])->send();
    }

    public function confirmPayment(Request $request)
    {
        $code = Str::after($request->order_desc, 'code:');
        $booking = Booking::where('code', $code)->first();

        if (!$booking)
            throw new Exception(__("Payment not found. Code:" . $code));

        $euplatesc = VendorEuPlatesc::where('vendor_id', $booking->vendor_id)->first();
        if (!$euplatesc)
            throw new Exception(__("Vendor error, euplatesc credentials not found."));

        $key = $euplatesc->key;

        $data =  array(
            'amount'     => addslashes(trim(@$_POST['amount'])),
            'curr'       => addslashes(trim(@$_POST['curr'])),
            'invoice_id' => addslashes(trim(@$_POST['invoice_id'])),
            'ep_id'      => addslashes(trim(@$_POST['ep_id'])),
            'merch_id'   => addslashes(trim(@$_POST['merch_id'])),
            'action'     => addslashes(trim(@$_POST['action'])),
            'message'    => addslashes(trim(@$_POST['message'])),
            'approval'   => addslashes(trim(@$_POST['approval'])),
            'timestamp'  => addslashes(trim(@$_POST['timestamp'])),
            'nonce'      => addslashes(trim(@$_POST['nonce'])),
        );

        foreach (['sec_status', 'rrn', 'mcard', 'card_exp', 'discount_amount', 'card_type', 'bin', 'rate', 'card_holder', 'email', 'rtype', 'cce'] as $param) {
            if (isset($_POST[$param])) $data[$param] = addslashes(trim($_POST[$param]));
        }

        $data['fp_hash'] = strtoupper($this->euplatesc_mac($data, $key));
        $fp_hash = addslashes(trim(@$_POST['fp_hash']));


        if ($data['fp_hash'] === $fp_hash) {
            if ($data['action'] == "0") {

                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'completed';
                    $payment->logs = json_encode($request);
                    $payment->save();
                }

                $booking->paid += (float)$booking->pay_now;
                // $booking->markAsPaid();
                $booking->status = 'paid';
                $booking->save();
            } else {
                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = json_encode($request);
                    $payment->save();
                }

                $booking->paid += (float)$booking->pay_now;
                // $booking->markAsPaid();
                $booking->status = 'unpaid';
                $booking->save();
            }
        } else {
            $payment = $booking->payment;
            if ($payment) {
                $payment->status = 'fail';
                $payment->logs = json_encode($request);
                $payment->save();
            }
            try {
                $booking->markAsPaymentFailed();
            } catch (\Throwable $e) {
                Log::warning($e->getMessage());
            }
        }
        
        return redirect($booking->getDetailUrl(false));
        // return redirect()->to(url('/'));
        // return; //IMPORTANT to print OK
    }

    public function euplatesc_mac($data, $key)
    {
        $str = NULL;
        foreach ($data as $d) {
            if ($d === NULL || strlen($d) == 0) {
                $str .= '-';
            } else {
                $str .= strlen($d) . $d;
            }
        }
        return hash_hmac('MD5', $str, pack('H*', $key));
    }


    public function supportedCurrency()
    {
        return [
            "ron" => "RON",
        ];
    }
}
