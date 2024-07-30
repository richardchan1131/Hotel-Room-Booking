<?php

namespace  Modules\Hotel;

use Modules\Core\Abstracts\BaseSettingsClass;
use Modules\Core\Models\Settings;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $configs = [
            'hotel' => [
                'id' => 'hotel',
                'title' => __("Hotel Settings"),
                'position' => 20,
                'view' => "Hotel::admin.settings.hotel",
                "keys" => [
                    'hotel_disable',
                    'hotel_page_search_title',
                    'hotel_page_search_banner',
                    'hotel_layout_search',
                    'hotel_layout_item_search',
                    'hotel_attribute_show_in_listing_page',
                    'hotel_location_search_style',
                    'hotel_page_limit_item',

                    'hotel_enable_review',
                    'hotel_review_approved',
                    'hotel_enable_review_after_booking',
                    'hotel_review_number_per_page',
                    'hotel_review_stats',

                    'hotel_page_list_seo_title',
                    'hotel_page_list_seo_desc',
                    'hotel_page_list_seo_image',
                    'hotel_page_list_seo_share',

                    'hotel_booking_buyer_fees',
                    'hotel_vendor_create_service_must_approved_by_admin',
                    'hotel_allow_vendor_can_change_their_booking_status',
                    'hotel_allow_vendor_can_change_paid_amount',
                    'hotel_allow_vendor_can_add_service_fee',
                    'hotel_search_fields',
                    'hotel_map_search_fields',

                    'hotel_allow_review_after_making_completed_booking',
                    'hotel_deposit_enable',
                    'hotel_deposit_type',
                    'hotel_deposit_amount',
                    'hotel_deposit_fomular',

                    'hotel_layout_map_option',
                    'hotel_icon_marker_map',

                    'hotel_map_lat_default',
                    'hotel_map_lng_default',
                    'hotel_map_zoom_default',

                    'hotel_location_radius_value',
                    'hotel_location_radius_type',
                ],
                'html_keys' => [

                ],
                'filter_demo_mode' => [
                ]
            ]
        ];
        return apply_filters(Hook::HOTEL_SETTING_CONFIG,$configs);
    }
}
