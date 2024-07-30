<?php
namespace Modules\Tracking;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->singleton('tracker', function () {
            return app()->make(Tracker::class);
        });
    }

    public static function getAdminMenu()
    {
        return [
            'tracking'=>[
                "position"=>20,
                'url'        => route('tracking.admin.index'),
                'title'      => __("Tracking"),
                'icon'       => 'fa fa-signal',
                'permission' => 'user_view',
            ]
        ];
    }
}
