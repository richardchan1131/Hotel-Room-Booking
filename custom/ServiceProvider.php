<?php

namespace Custom;

use File;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $listModule = array_map('basename', File::directories(__DIR__));
        foreach ($listModule as $module) {
            if (file_exists(__DIR__ . '/' . $module . '/Config/config.php')) {
                $this->publishes([
                    __DIR__ . '/' . $module . '/Config/config.php' => config_path(strtolower($module) . '.php'),
                ]);
            }
        }
    }

    public function register()
    {
        $listModule = array_map('basename', File::directories(__DIR__));
        foreach ($listModule as $module) {
            if (file_exists(__DIR__ . '/' . $module . '/Config/config.php')) {
                $this->mergeConfigFrom(
                    __DIR__ . '/' . $module . '/Config/config.php',
                    strtolower($module)
                );
            }

            if (is_dir(__DIR__ . '/' . $module . '/database/migrations')) {
                $this->loadMigrationsFrom(__DIR__ . '/' . $module . '/database/migrations');
            }

            if (is_dir(__DIR__ . '/' . $module . '/Routes')) {
                $this->loadRoutesFrom(__DIR__ . '/' . $module . '/Routes/web.php');
            }

            if (is_dir(__DIR__ . '/' . $module . '/Views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/Views', $module);
            }

            $class = "\Custom\\" . ucfirst($module) . "\\ModuleProvider";
            if (class_exists($class)) {
                $this->app->register($class);
            }
        }

        if (is_dir(__DIR__ . '/Layout')) {
            $this->loadViewsFrom(__DIR__ . '/Layout', 'Layout');
        }
    }

    public static function getModules()
    {
        return array_map('basename', array_filter(glob(base_path() . '/custom/*'), 'is_dir'));
    }
}
// namespace Custom;

// use File;
// use Illuminate\Support\ServiceProvider as SupportServiceProvider;

// class ServiceProvider extends SupportServiceProvider
// {
//     public function register(): void
//     {
//         $modules = array_map('basename', File::directories(__DIR__));
        
//         foreach($modules as $module)
//         {
//             if(file_exists(__DIR__. '/' . $module . '/config/config.php')){
//                 $this->publishes([
//                     __DIR__. '/' . $module . '/config/config.php' => config_path(strtolower($module).'.php'),
//                 ]);
//             }
//         }
//     }
    
//     public function boot(): void
//     {
//         $modules = array_map('basename', File::directories(__DIR__));
//         foreach($modules as $module)
//         {
//             if(is_dir(__DIR__. '/' . $module . '/database/migrations'))
//             {
//                 $this->loadMigrationsFrom(__DIR__. '/' . $module . '/database/migrations');
//             }

//             if(is_dir(__DIR__. '/' . $module . '/routes'))
//             {
//                 $this->loadRoutesFrom(__DIR__. '/' . $module . '/routes/web.php');
//             }

//             if (is_dir(__DIR__ . '/' . $module . '/views')) {
//                 $this->loadViewsFrom(__DIR__ . '/' . $module . '/views', $module);
//             }

//             $class = "\Custom\\".ucfirst($module)."\\ModuleProvider";
//             if(class_exists($class)) {
//                 $this->app->register($class);
//             }
//         }
//     }

//     public static function getModules(){
//         return array_map('basename', array_filter(glob(base_path().'/custom/*'), 'is_dir'));
//     }
// }