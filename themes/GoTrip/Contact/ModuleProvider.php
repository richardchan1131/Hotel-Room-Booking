<?php

namespace Themes\GoTrip\Contact;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){
        add_filter(\Modules\Core\Hook::CORE_SETTING_CONFIG,[$this,'alterSettings']);
        add_action(\Modules\Core\Hook::CORE_SETTING_AFTER_CONTACT,[$this,'showCustomFieldsAfterContact']);
    }
    public function alterSettings($settings){
        if(!empty($settings['general'])){
            $settings['general']['keys'][] = 'page_contact_lists';
            $settings['general']['keys'][] = 'page_contact_iframe_google_map';
            $settings['general']['keys'][] = 'page_contact_why_choose_us';
            $settings['general']['keys'][] = 'page_contact_why_choose_us_title';
            $settings['general']['keys'][] = 'page_contact_why_choose_us_desc';
        }
        return $settings;
    }
    public function showCustomFieldsAfterContact(){
        echo view('Core::admin.settings.setting-after-contact');
    }
}
