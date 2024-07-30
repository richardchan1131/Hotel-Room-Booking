<?php
namespace  Modules\Agency;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id' => 'agencies',
                'title' => __("Agencies Settings"),
                'position' => 20,
                'view' => "Agency::admin.settings.agency",
                "keys"=>[
                    'agency_disable',
                    'agency_page_search_title',
                    'agency_page_search_banner',
                    'agency_layout_search',
                    'agency_location_search_style',
                    'agency_enable_review',
                    'agency_review_approved',
                    'agency_review_number_per_page',
                    'agency_review_stats',
                ],
                'html_keys'=>[

                ]
            ],
            [
                'id'        => 'agent',
                'title'     => __("Agent Settings"),
                'position'  => 50,
                'view'      => "Agency::admin.settings.agent",
                "keys"      => [
                    'vendor_enable',
                    'vendor_commission_type',
                    'vendor_commission_amount',
                    'vendor_auto_approved',
                    'vendor_role',
                    'vendor_show_email',
                    'vendor_show_phone',
                    'vendor_payout_methods',
                    'vendor_payout_booking_status',
                    'vendor_term_conditions',
                    'disable_payout',

                    'enable_mail_vendor_registered',
                    'vendor_subject_email_registered',
                    'vendor_content_email_registered',
                    'admin_enable_mail_vendor_registered',
                    'admin_subject_email_vendor_registered',
                    'admin_content_email_vendor_registered',
                ],
                'html_keys' => [

                ],
                'filter_values_callback'=>[__CLASS__,'filterValuesBeforeSaving']
            ],
        ];
    }

    public static function filterValuesBeforeSaving($setting_values, Request $request)
    {
        $all = [];
        if(!empty($setting_values['vendor_payout_methods']) and is_array($setting_values['vendor_payout_methods']))
        {
            foreach ($setting_values['vendor_payout_methods'] as $key=>$method)
            {
                if(empty($method['name']) or empty($method['id'])){
                    unset($setting_values['vendor_payout_methods'][$key]);
                    continue;
                }
                $setting_values['vendor_payout_methods'][$key]['id'] = Str::slug($method['id'],'_');

                if(in_array($setting_values['vendor_payout_methods'][$key]['id'],$all))
                {
                    unset($setting_values['vendor_payout_methods'][$key]);
                    continue;
                }

                $all[] = $setting_values['vendor_payout_methods'][$key]['id'];
            }

            $setting_values['vendor_payout_methods'] = array_values($setting_values['vendor_payout_methods']);
        }
        return $setting_values;
    }
}
