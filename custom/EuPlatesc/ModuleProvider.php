<?php

namespace Custom\EuPlatesc;

use Custom\EuPlatesc\Gateways\EuPlatescGateway;
use Illuminate\Support\Arr;

class ModuleProvider extends \Modules\ModuleServiceProvider
{
    public function register()
    {
        $gateways = config('payment.gateways');

        $gateways = Arr::add($gateways, 'EuPlatesc', EuPlatescGateway::class);

        // Store the updated 'gateways' array back into the configuration
        config(['payment.gateways' => $gateways]);
    }

    public function boot()
    {
    }

    public static function getUserMenu()
    {
        $res = [];

        $res['payment_settings'] = [
            'position'   => 89,
            'url'        => route('euplatesc.index'),
            'title'      => __("EuPlatesc settings"),
            'icon'       => 'icon ion-md-cash',
            'permission' => 'dashboard_vendor_access',
        ];

        return $res;
    }
}
