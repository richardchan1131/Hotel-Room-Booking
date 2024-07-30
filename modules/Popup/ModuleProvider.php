<?php
namespace Modules\Popup;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

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
        return [
            'popup'=>[
                "position"=>50,
                'url'        => route('popup.admin.index'),
                'title'      => __('Popup'),
                'icon'       => 'ion ion-ios-cube',
                'permission' => 'popup_view',
                'group' => 'system'
            ]
        ];
    }

}
