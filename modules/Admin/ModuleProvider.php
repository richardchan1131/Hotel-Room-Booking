<?php
namespace Modules\Admin;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        Crud::register([
            'test'=>TestCrud::class
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->register(RouterServiceProvider::class);
    }

}
