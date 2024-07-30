<?php
namespace Modules;

use Modules\Theme\ModuleProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected static $coreModuleNames = ['Api','Social','Sms','Page','News','Admin','Booking','Order','Contact','Core','Dashboard','Email','Language','Layout','Media','Report','Review','Template','Theme','Tracking','Type','User','Vendor'];

    protected static $installedModules = [];

    public function boot()
    {
        $listModule = array_map('basename', \Illuminate\Support\Facades\File::directories(__DIR__));
        foreach ($listModule as $module) {
            if (is_dir(__DIR__ . '/' . $module . '/Views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/Views', $module);
            }
        }
        if (is_dir(__DIR__ . '/Layout')) {
            $this->loadViewsFrom(__DIR__ . '/Layout', 'Layout');
        }

    }

    public function register()
    {
        $this->app->register(ModuleProvider::class);
    }


    public static function getModules(){
        return array_keys(static::getActivatedModules());
    }

    public static function getActivatedModules(){
        $res = [];

        $class = \Modules\Theme\ThemeManager::currentProvider();
        if(class_exists($class)){
            $modules  = $class::getModules();
            $coreModules = static::getCoreModules();
            foreach ($modules as $module=>$class){
                if(class_exists($class)) {
                    $res[$module] = [
                        'id'=>$module,
                        'class'=>$class,
                        'parent'=>$coreModules[$module]['class'] ?? ''
                    ];
                }
            }
        }

        return $res;
    }
    public static function getCoreModules(){
        $res = [];

        $class = \Modules\Theme\ThemeManager::currentProvider();
        if(class_exists($class)){
            foreach ($class::getCoreModules() as $module=>$class){
                if(class_exists($class)) {
                    $res[$module] = [
                        'id'=>$module,
                        'class'=>$class
                    ];
                }
            }
        }

        return $res;
    }
    public static function getThemeModules(){
        $res = [];

        $class = \Modules\Theme\ThemeManager::currentProvider();
        if(class_exists($class)){
            foreach ($class::getThemeModules() as $module=>$class){
                if(class_exists($class)) {
                    $res[$module] = [
                        'id'=>$module,
                        'class'=>$class
                    ];
                }
            }
        }

        return $res;
    }

    public static function getInstalledModules(){

        if(empty(static::$installedModules)){
            $listModule = array_map('basename', \Illuminate\Support\Facades\File::directories(__DIR__));
            foreach ($listModule as $module) {
                if (is_dir(__DIR__ . '/' . $module . '/Views')) {
                    static::$installedModules[$module] = "\\Modules\\".ucfirst($module)."\\ModuleProvider";
                }
            }
        }
        return static::$installedModules;
    }
    public static function getManageableModules(){
        $res = [];
        foreach (static::getInstalledModules() as $id=>$class){
            if(!in_array($id,static::$coreModuleNames)) $res[$id] = $class;
        }
        return $res;
    }
}
