<?php
namespace Modules;
use Illuminate\Contracts\Foundation\CachesConfiguration;

class ModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public static $name;
    public static $desc = "";
    public static $version = "1.0";
    public static $author = "";
    public static $thumb;
    public static $screenshot;
    public static $core_compatible = [];
    public static $isPro = false;


    /**
     * @return array
     */
    public static function getAdminMenu(){
        return [];
    }

    /**
     * @return array
     */
    public static function getAdminMenuGroups()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getAdminSubmenu(){
        return [];
    }

    /**
     * @return array
     */
    public static function getBookableServices()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getPayableServices(){
        return [];
    }

    /**
     * @return array
     */
    public static function getReviewableServices(){
        return [];
    }

    public static function getMenuBuilderTypes(){
        return [];
    }

    public static function adminUserMenu(){
        return [];
    }

    public static function adminUserSubMenu(){
        return [];
    }

    public static function getUserMenu(){
        return [];
    }

    public static function getUserSubMenu(){
        return [];
    }

    public static function getTemplateBlocks(){
        return [];
    }
    public static function getPaymentGateway(){
        return [];
    }

    public static function getActionsHook(){
        return [];
    }
    public static function getFiltersHook(){
        return [];
    }

    function register()
    {
        $actions = static::getActionsHook();
        if(!empty($actions)){
            foreach ($actions as $args){
                call_user_func_array('add_action',$args);
            }
        }
        $filters = static::getFiltersHook();
        if(!empty($filters)){
            foreach ($filters as $args){
                call_user_func_array('add_filter',$args);
            }
        }
    }


    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $config = $this->app->make('config');

            // Allow overwrite config
            $config->set($key, array_merge(
                $config->get($key, []),require $path,
            ));
        }
    }

    public static function getName(){
        $class = explode('\\',static::class);
        return static::$name ?: $class[1];
    }
    public static function getDesc(){
        return static::$desc;
    }
    public static function getThumb(){
        return static::$thumb;
    }
    public static function getVersion(){
        return static::$version;
    }
    public static function getAuthor(){
        return static::$author;
    }
    public static function getScreenshot(){
        return static::$screenshot;
    }
}
