<?php
namespace Themes\GoTrip\Location;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Location\Hook;
use Modules\Location\Models\Location;
use Modules\Location\Models\LocationTranslation;
use Modules\Template\Models\Template;
use Themes\GoTrip\Location\Blocks\ListLocations;

class ModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(Location::class,\Themes\GoTrip\Location\Models\Location::class);
        Template::register(static::getTemplateBlocks());
    }

    public function boot(){
        add_action(Hook::FORM_AFTER_TRIP_IDEA,[$this,'location_extra_info']);
        add_action(Hook::BEFORE_SAVING,[$this,'save_location_extra_info']);
    }

    public function location_extra_info(Location $location){
        echo view("Location::admin.location_extra_info",['row'=>$location])->render();
    }

    public function save_location_extra_info(Location $location,Request $request){
        if($request->input('gotrip_save_extra'))
        {
            $location->general_info = $request->input('general_info');
        }
    }

    public static function getTemplateBlocks(){
        return [
            'list_locations'=> ListLocations::class
        ];
    }
}
