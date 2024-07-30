<?php
namespace Modules\Core;
use Illuminate\Support\Facades\Event;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\CreateReviewEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Core\Helpers\HookManager;
use Modules\Core\Helpers\SitemapHelper;
use Modules\Core\Listeners\CreatedServicesListen;
use Modules\Core\Listeners\CreateReviewListen;
use Modules\Core\Listeners\UpdatedServicesListen;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        Event::listen(CreatedServicesEvent::class,CreatedServicesListen::class);
        Event::listen(UpdatedServiceEvent::class,UpdatedServicesListen::class);
        Event::listen(CreateReviewEvent::class,CreateReviewListen::class);

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);

        $this->app->singleton(SitemapHelper::class,function($app){
            return new SitemapHelper();
        });
        $this->app->singleton('hook_manager',function(){
            return $this->app->make(HookManager::class);
        });

        $this->app->bind(\RachidLaasri\LaravelInstaller\Controllers\DatabaseController::class,\Modules\Core\Installer\DatabaseController::class);
        $this->app->bind(\RachidLaasri\LaravelInstaller\Controllers\EnvironmentController::class,\Modules\Core\Installer\EnvironmentController::class);
    }
    public static function getAdminMenu()
    {
        return [
            'menu' => [
                "position"   => 60,
                'url'        => route('core.admin.menu.index'),
                'title'      => __("Menu"),
                'icon'       => 'icon ion-ios-apps',
                'permission' => 'menu_view',
                'group'      => 'system',
            ],
            'tools'=>[
                "position"=>90,
                'url'      => route('core.admin.tool.index'),
                'title'    => __("Tools"),
                'icon'     => 'icon ion-ios-hammer',
                'group' => 'system',
                'children' => [
                    'module'=>[
                        'title'=>__("Modules"),
                        'url'=>route('core.admin.module.index'),
                        'icon'=>'icon ion-md-color-wand',
                        'permission'=>'setting_update'
                    ],
                    'language'=>[
                        'url'        => route('language.admin.index'),
                        'title'      => __('Languages'),
                        'icon'       => 'icon ion-ios-globe',
                        'permission' => 'language_manage',
                    ],
                    'translation'=>[
                        'url'        => route('language.admin.translations.index'),
                        'title'      => __("Translation Manager"),
                        'icon'       => 'icon ion-ios-globe',
                        'permission' => 'language_translation',
                    ],
                    'logs'=>[
                        'url'        => route('admin.logs'),
                        'title'      => __("System Logs"),
                        'icon'       => 'icon ion-ios-nuclear',
                        'permission' => 'system_log_view',
                    ],
                ]
            ],
        ];
    }

    public static function getAdminMenuGroups()
    {
        return [
            'system' => [
                'name'     => __("System"),
                'position' => 200
            ]
        ];
    }
}
