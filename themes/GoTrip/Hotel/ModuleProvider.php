<?php
namespace Themes\GoTrip\Hotel;

use Illuminate\Support\ServiceProvider;

use Modules\ModuleServiceProvider;
use Modules\Page\Hook;
use Modules\Template\Models\Template;
use Themes\GoTrip\Hotel\Blocks\FormSearchHotel;
use Themes\GoTrip\Hotel\Blocks\ListHotel;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){
        $this->mergeConfigFrom(__DIR__ . '/Configs/hotel.php','hotel');
        Template::register(static::getTemplateBlocks());
        add_filter(\Modules\Hotel\Hook::HOTEL_SETTING_CONFIG,[$this,'alterSettings']);
        add_action(\Modules\Hotel\Hook::HOTEL_SETTING_AFTER_MAP,[$this,'showCustomFieldsAfterMap']);
    }

    public function alterSettings($settings){
        if(!empty($settings['hotel'])){
            $settings['hotel']['keys'][] = 'hotel_map_image';
        }
        return $settings;
    }

    public function showCustomFieldsAfterMap(){
        echo view('Hotel::admin.setting-after-map');
    }

    public static function getTemplateBlocks(){
        return [
            'form_search_hotel'=>FormSearchHotel::class,
            'list_hotel'=>ListHotel::class,
        ];
    }
}
