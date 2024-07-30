<?php
namespace Modules\Car;
use Modules\Car\Models\Car;
use Modules\ModuleServiceProvider;
use Modules\User\Helpers\PermissionHelper;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        PermissionHelper::add([
            // Car
            'car_view',
            'car_create',
            'car_update',
            'car_delete',
            'car_manage_others',
            'car_manage_attributes',
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
        if(!Car::isEnable()) return [];
        return [
            'car'=>[
                "position"=>45,
                'url'        => route('car.admin.index'),
                'title'      => __('Car'),
                'icon'       => 'ion-logo-model-s',
                'permission' => 'car_view',
                'children'   => [
                    'add'=>[
                        'url'        => route('car.admin.index'),
                        'title'      => __('All Cars'),
                        'permission' => 'car_view',
                    ],
                    'create'=>[
                        'url'        => route('car.admin.create'),
                        'title'      => __('Add new Car'),
                        'permission' => 'car_create',
                    ],
                    'attribute'=>[
                        'url'        => route('car.admin.attribute.index'),
                        'title'      => __('Attributes'),
                        'permission' => 'car_manage_attributes',
                    ],
                    'availability'=>[
                        'url'        => route('car.admin.availability.index'),
                        'title'      => __('Availability'),
                        'permission' => 'car_create',
                    ],
                    'recovery'=>[
                        'url'        => route('car.admin.recovery'),
                        'title'      => __('Recovery'),
                        'permission' => 'car_view',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Car::isEnable()) return [];
        return [
            'car'=>Car::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        if(!Car::isEnable()) return [];
        return [
            'car'=>[
                'class' => Car::class,
                'name'  => __("Car"),
                'items' => Car::searchForMenu(),
                'position'=>51
            ]
        ];
    }

    public static function getUserMenu()
    {
        $res = [];
        if(Car::isEnable()){
            $res['car'] = [
                'url'   => route('car.vendor.index'),
                'title'      => __("Manage Car"),
                'icon'       => Car::getServiceIconFeatured(),
                'position'   => 70,
                'permission' => 'car_view',
                'children' => [
                    [
                        'url'   => route('car.vendor.index'),
                        'title'  => __("All Cars"),
                    ],
                    [
                        'url'   => route('car.vendor.create'),
                        'title'      => __("Add Car"),
                        'permission' => 'car_create',
                    ],
                    [
                        'url'        => route('car.vendor.availability.index'),
                        'title'      => __("Availability"),
                        'permission' => 'car_create',
                    ],
                    [
                        'url'   => route('car.vendor.recovery'),
                        'title'      => __("Recovery"),
                        'permission' => 'car_create',
                    ],
                ]
            ];
        }
        return $res;
    }

    public static function getTemplateBlocks(){
        if(!Car::isEnable()) return [];
        return [
            'form_search_car'=>"\\Modules\\Car\\Blocks\\FormSearchCar",
            'list_car'=>"\\Modules\\Car\\Blocks\\ListCar",
            'car_term_featured_box'=>"\\Modules\\Car\\Blocks\\CarTermFeaturedBox",
        ];
    }
}
