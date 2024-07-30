<?php

namespace Themes\GoTrip\Core;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){
        add_action(\Modules\Core\Hook::CORE_SETTING_AFTER_LOGO,[$this,'showCustomFieldsAfterLogo']);
        add_action(\Modules\Core\Hook::CORE_SETTING_AFTER_HOMEPAGE,[$this,'showCustomFieldsAfterHomePage']);
        add_filter(\Modules\Core\Hook::CORE_SETTING_CONFIG,[$this,'alterSettings']);

        add_action(\Modules\Core\Hook::CORE_SETTING_AFTER_FOOTER,[$this,'showCustomFieldsAfterFooter']);
    }
    public function alterSettings($settings){
        if(!empty($settings['general'])){
            $settings['general']['keys'][] = 'logo_id_dark';
            $settings['general']['keys'][] = 'enable_preload';
            $settings['general']['keys'][] = 'logo_preload_id';

            $settings['general']['keys'][] = 'footer_content_left';
            $settings['general']['keys'][] = 'footer_content_right';
            $settings['general']['keys'][] = 'footer_style';
        }
        return $settings;
    }
    public function showCustomFieldsAfterLogo(){
        echo view('Core::admin.settings.setting-after-logo');
    }
    public function showCustomFieldsAfterHomePage(){
        echo view('Core::admin.settings.setting-after-homepage');
    }

    public function showCustomFieldsAfterFooter(){
        echo view('Core::admin.settings.setting-after-footer');
    }
}
