<?php

namespace Pro;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {
        foreach (static::getModules() as $module) {
            $class = "\Pro\\" . ucfirst($module) . "\\ModuleProvider";
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
        return ['support', 'booking', 'ai'];
    }
}
