<?php

namespace  Modules\Flight;

use Modules\Core\Abstracts\BaseSettingsClass;
use Modules\Core\Models\Settings;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'flight',
                'title' => __("Flight Settings"),
                'position'=>20,
                'view'=>"Flight::admin.settings.setting",
                "keys"=>[
                    'flight_disable',
                    'flight_page_search_title',
                    'flight_page_search_banner',
                    'flight_layout_search',
                    'flight_location_search_style',
                    'flight_page_limit_item',

                    'flight_enable_review',
                    'flight_review_approved',
                    'flight_enable_review_after_booking',
                    'flight_review_number_per_page',
                    'flight_review_stats',

                    'flight_page_list_seo_title',
                    'flight_page_list_seo_desc',
                    'flight_page_list_seo_image',
                    'flight_page_list_seo_share',

                    'flight_booking_buyer_fees',
                    'flight_vendor_create_service_must_approved_by_admin',
                    'flight_allow_vendor_can_change_their_booking_status',
                    'flight_allow_vendor_can_change_paid_amount',
                    'flight_allow_vendor_can_add_service_fee',
                    'flight_search_fields',
                    'flight_map_search_fields',

                    'flight_allow_review_after_making_completed_booking',
                    'flight_deposit_enable',
                    'flight_deposit_type',
                    'flight_deposit_amount',
                    'flight_deposit_fomular',

                    'flight_layout_map_option',
                    'flight_icon_marker_map',
                    'flight_booking_type',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
