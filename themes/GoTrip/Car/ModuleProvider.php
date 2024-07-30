<?php

namespace Themes\GoTrip\Car;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Modules\ModuleServiceProvider;
use Modules\Template\Models\Template;
use Themes\GoTrip\Car\Blocks\FormSearchCar;
use Themes\GoTrip\Car\Blocks\ListCar;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){

        $this->mergeConfigFrom(__DIR__ . '/Configs/car.php','car');

        Template::register(static::getTemplateBlocks());

        add_filter(\Modules\Car\Hook::CAR_SETTING_CONFIG,[$this,'alterSettings']);
        add_action(\Modules\Car\Hook::CAR_SETTING_AFTER_MAP,[$this,'showCustomFieldsAfterMap']);

    }

    public function alterSettings($settings){
        if(!empty($settings['car'])){
            $settings['car']['keys'][] = 'car_map_image';
        }
        return $settings;
    }
    public function showCustomFieldsAfterMap(){
        echo view('Car::admin.setting-after-map');
    }

    public static function getTemplateBlocks(){
        return [
            'form_search_car' => FormSearchCar::class,
            'list_car' => ListCar::class,
        ];
    }
}
