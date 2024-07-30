<?php

namespace  Modules\Space;

use Modules\Core\Abstracts\BaseSettingsClass;
use Modules\Core\Models\Settings;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $configs = [
            'space' => [
                'id' => 'space',
                'title' => __("Space Settings"),
                'position' => 20,
                'view' => "Space::admin.settings.space",
                "keys" => [
                    'space_disable',
                    'space_page_search_title',
                    'space_page_search_banner',
                    'space_layout_search',
                    'space_location_search_style',
                    'space_page_limit_item',

                    'space_enable_review',
                    'space_review_approved',
                    'space_enable_review_after_booking',
                    'space_review_number_per_page',
                    'space_review_stats',

                    'space_page_list_seo_title',
                    'space_page_list_seo_desc',
                    'space_page_list_seo_image',
                    'space_page_list_seo_share',

                    'space_booking_buyer_fees',
                    'space_vendor_create_service_must_approved_by_admin',
                    'space_allow_vendor_can_change_their_booking_status',
                    'space_allow_vendor_can_change_paid_amount',
                    'space_allow_vendor_can_add_service_fee',
                    'space_search_fields',
                    'space_map_search_fields',

                    'space_allow_review_after_making_completed_booking',
                    'space_deposit_enable',
                    'space_deposit_type',
                    'space_deposit_amount',
                    'space_deposit_fomular',

                    'space_layout_map_option',
                    'space_icon_marker_map',
                    'space_booking_type',

                    'space_map_lat_default',
                    'space_map_lng_default',
                    'space_map_zoom_default',

                    'space_location_radius_value',
                    'space_location_radius_type',
                ],
                'html_keys' => [

                ],
                'filter_demo_mode' => [
                ]
            ]
        ];
        return apply_filters(Hook::SPACE_SETTING_CONFIG,$configs);
    }
}
