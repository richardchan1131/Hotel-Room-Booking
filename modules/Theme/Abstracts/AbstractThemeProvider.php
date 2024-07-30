<?php
namespace Modules\Theme\Abstracts;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

abstract class AbstractThemeProvider extends ServiceProvider
{

    public static $name;

    public static $screenshot;

    public static $version = "1.0";


    public static $core_modules = [];

    public static $modules = [];

    public static $seeder;

    public static $seederForReImport;


    public static $parent;

    public static $module_compatible = [];

    public static $core_compatible = [];

    /**
     * Return Theme Info
     *
     * @return array
     */
    static function info(){

    }

    public static function getTemplateBlocks(){
        return [];
    }

    public static function getModules()
    {
        return array_merge(static::$core_modules,static::$modules);
    }

    public static function getCoreModules(){
        return static::$core_modules;
    }

    public static function getThemeModules(){
        return static::$modules;
    }


    public static function lastSeederRun(){
        return (int) setting_item('theme_'.static::class.'_seed_run');
    }
    public static function updateLastSeederRun(){
        return setting_update_item('theme_'.static::class.'_seed_run',time());
    }

    public static function runSeeder(){
        $seeder = static::$seederForReImport ? : static::$seeder;

        if(!class_exists($seeder)) return;

        Artisan::call('db:seed', ['--class' => $seeder,'--force'=>true]);

        static::updateLastSeederRun();
    }
}
