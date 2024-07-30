<?php
namespace  Modules\News;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $configs = [
            'news' => [
                'id'   => 'news',
                'title' => __("News Settings"),
                'position'=>30,
                'view'=>"News::admin.settings.news",
                "keys"=>[
                    'news_page_list_title',
                    'news_posts_per_page',
                    'news_page_list_banner',
                    'news_sidebar',
                    'news_page_list_seo_title',
                    'news_page_list_seo_desc',
                    'news_page_list_seo_image',
                    'news_page_list_seo_share',

                    'news_vendor_need_approve',
                    'news_layout_search'
                ],
                'html_keys'=>[

                ]
            ]
        ];
        return apply_filters(Hook::NEWS_SETTING_CONFIG, $configs);
    }
}
