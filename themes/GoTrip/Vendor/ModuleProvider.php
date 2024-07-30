<?php
namespace Themes\GoTrip\Vendor;

use Illuminate\Support\ServiceProvider;

use Modules\ModuleServiceProvider;
use Modules\Page\Hook;
use Modules\Template\Models\Template;
use Themes\GoTrip\Hotel\Blocks\FormSearchHotel;
use Themes\GoTrip\Hotel\Blocks\ListHotel;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){
        add_filter(\Modules\Vendor\Hook::VENDOR_SETTING_CONFIG,[$this,'alterSettings']);
        add_action(\Modules\Vendor\Hook::VENDOR_SETTING_AFTER_GENERAL,[$this,'showCustomFields']);
    }

    public function alterSettings($settings){
        if(!empty($settings['vendor'])){
            $settings['vendor']['keys'][] = 'vendor_page_become_an_expert';
        }
        return $settings;
    }

    public function showCustomFields(){
        echo view('Vendor::admin.setting-after-general');
    }

}
