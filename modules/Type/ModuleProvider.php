<?php
namespace Modules\Type;


use Modules\ModuleServiceProvider;
use Modules\Type\Types\SpaType;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(TypeManager $type_manager){
        //$type_manager->register("spa",SpaType::class);
    }

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->singleton(TypeManager::class);
    }
}
