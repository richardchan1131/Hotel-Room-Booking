<?php
namespace Modules\Flight;
use Modules\ModuleServiceProvider;
use Modules\Flight\Models\Flight;
use Modules\User\Helpers\PermissionHelper;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        PermissionHelper::add([
            'flight_view',
            'flight_create',
            'flight_update',
            'flight_delete',
            'flight_manage_others',
            'flight_manage_attributes',
        ]);
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        if(!Flight::isEnable()) return [];
        return [
            'flight'=>[
                "position"=>41,
                'url'        => route('flight.admin.index'),
                'title'      => __('Flight'),
                'icon'       => 'ion ion-md-airplane',
                'permission' => 'flight_view',
                'children'   => [
                    'add'=>[
                        'url'        => route('flight.admin.index'),
                        'title'      => __('All Flights'),
                        'permission' => 'flight_view',
                    ],
                    'create'=>[
                        'url'        => route('flight.admin.create'),
                        'title'      => __('Add new Flight'),
                        'permission' => 'flight_create',
                    ],
                    'airline'=>[
                        'url'        => route('flight.admin.airline.index'),
                        'title'      => __('Airline'),
                    ],
                    'airport'=>[
                        'url'        => route('flight.admin.airport.index'),
                        'title'      => __('Airport'),
                    ],
                    'seat_type'=>[
                        'url'        => route('flight.admin.seat_type.index'),
                        'title'      => __('Seat Type'),
                    ],
                    'attribute'=>[
                        'url'        => route('flight.admin.attribute.index'),
                        'title'      => __('Attributes'),
                        'permission' => 'flight_manage_attributes',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Flight::isEnable()) return [];
        return [
            'flight'=>Flight::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        return [];
    }

    public static function getUserMenu()
    {
        $res = [];
        if (Flight::isEnable()) {
            $res['flight'] = [
                'url'        => route('flight.vendor.index'),
                'title'      => __("Manage Flight"),
                'icon'       => Flight::getServiceIconFeatured(),
                'position'   => 60,
                'permission' => 'flight_view',
                'children'   => [
                    [
                        'url'   => route('flight.vendor.index'),
                        'title' => __("All Flights"),
                    ],
                    [
                        'url'        => route('flight.vendor.create'),
                        'title'      => __("Add Flights"),
                        'permission' => 'flight_create',
                    ],
                ]
            ];
        }
        return $res;
    }

    public static function getTemplateBlocks(){
        if(!Flight::isEnable()) return [];
        return [
            'form_search_flight'=>"\\Modules\\Flight\\Blocks\\FormSearchFlight",
        ];
    }
}
