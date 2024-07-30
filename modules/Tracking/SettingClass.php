<?php


namespace Modules\Tracking;


use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'tracking',
                'title' => __("Tracking Settings"),
                'position'=>50,
                'view'=>"Tracking::admin.settings.tracking",
                "keys"=>[
                    'tracking_enable',
                    'tracking_ignore_ip',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
