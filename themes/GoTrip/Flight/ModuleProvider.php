<?php
namespace Themes\GoTrip\Flight;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Modules\ModuleServiceProvider;
use Modules\Template\Models\Template;
use Themes\GoTrip\Flight\Blocks\FormSearchFlight;

class ModuleProvider extends ServiceProvider
{
    public function boot(){

        Template::register(static::getTemplateBlocks());

    }

    public static function getTemplateBlocks(){
        return [
            'form_search_flight' => FormSearchFlight::class
        ];
    }
}
