<?php
namespace Modules\Agency;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Agency\Blocks\OurTeam;
use Modules\Agency\Blocks\Partners;
use Modules\Agency\Blocks\VendorRegisterForm;
use Modules\Agency\Models\Agency;
use Modules\User\Helpers\PermissionHelper;
use Themes\Findhouse\User\Models\User;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        // Setup Permission
        PermissionHelper::add([
            'agencies_view',
            'agencies_create',
            'agencies_update',
            'agencies_delete',
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

    public static function getReviewableServices()
    {
        return [
            'agencies' => Agency::class,
            'agent'    => User::class
        ];
    }

    public static function getAdminMenu()
    {
        $res = [];
        if (Agency::isEnable()) {
            $res['agencies'] = [
                "position"   => 45,
                'url'        => 'admin/module/agencies',
                'title'      => __("Agencies"),
                'icon'       => 'icon ion-md-umbrella',
                'permission' => 'agencies_view',
                'children'   => [
                    'agency_view'=>[
                        'url'        => 'admin/module/agencies',
                        'title'      => __('All Agency'),
                        'permission' => 'agencies_view',
                    ],
                    'agency_create'=>[
                        'url'        => 'admin/module/agencies/form',
                        'title'      => __("Add Agency"),
                        'permission' => 'agencies_create',
                    ],
                ],
            ];
        }
        return $res;
    }


    public static function getUserMenu()
    {
        $res = [];
        if(is_agency_owner()){
            if(Agency::isEnable()){
                $res['agencies'] = [
                    'title'      => __("Manage Agency"),
                    'icon'       => 'icon ion-md-umbrella',
                    'permission' => 'agencies_view',
                    'position'   => 31,
                    'url'        => route('agency.vendor.index'),
                ];
            }
        }

        return $res;
    }

    public static function getMenuBuilderTypes()
    {
        if(!Agency::isEnable()) return [];

        return [
            [
                'class' => Agency::class,
                'name'  => __("Agencies"),
                'items' => Agency::searchForMenu(),
                'position'=> 20
            ],
        ];
    }

    public static function getTemplateBlocks(){
        if(!Agency::isEnable()) return [];

        return [
            'our_team'=>OurTeam::class,
            'partners'=>Partners::class,
            'vendor_register_form'=>VendorRegisterForm::class
        ];
    }
}
