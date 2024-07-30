<?php

namespace Themes\GoTrip\Boat;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Modules\ModuleServiceProvider;
use Modules\Template\Models\Template;
use Themes\GoTrip\Boat\Blocks\FormSearchBoat;
use Themes\GoTrip\Boat\Blocks\ListBoat;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot(){

        $this->mergeConfigFrom(__DIR__ . '/Configs/boat.php','boat');

        Template::register(static::getTemplateBlocks());

    }

    public static function getTemplateBlocks(){
        return [
            'form_search_boat' => FormSearchBoat::class,
            'list_boat' => ListBoat::class,
        ];
    }
}
