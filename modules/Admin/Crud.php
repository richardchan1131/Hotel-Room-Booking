<?php


namespace Modules\Admin;


use Modules\Admin\Crud\Components\BaseComponent;

class Crud
{

    static protected $modules = [];
    static protected $components = [];

    public static function modules(){
        return static::$modules;
    }

    /**
     * @param $module
     * @return BaseCrudModule
     * @throws \Exception
     */
    public static function module($module){
        $all = static::modules();
        if(empty($all[$module]) or !class_exists($all[$module])) throw new \Exception("CRUD module not found: ".$module);
        return new $all[$module];
    }

    public static function components(){
        return static::$components;
    }

    /**
     * @param $component
     * @return BaseComponent
     * @throws \Exception
     */
    public static function component($component){
        $all = static::components();
        if(empty($all[$component]) or !class_exists($all[$component])) {
            return new BaseComponent();
        }
        return new $all[$component];
    }

    public static function register($arr){
        foreach ($arr as $k=>$v){
            if(!class_exists($v) or !is_subclass_of($v,\Modules\Admin\BaseCrudModule::class)) throw new \Exception("CRUD class must be sub class of BaseCurdModule: ".$v);

            if(array_key_exists($k,static::$modules))
            {
                $class_name = static::$modules[$k];
                if(version_compare($class_name::$version,$v::$version) > 0){
                    static::$modules[$k] = $v;
                }
            }else {
                static::$modules[$k] = $v;
            }
        }
    }

    public static function registerComponent($arr){
        foreach ($arr as $k=>$v){
            if(!class_exists($v) or !is_subclass_of($v,\Modules\Admin\Crud\Components\BaseComponent::class)) throw new \Exception("CRUD Component class must be sub class of BaseComponent");

            if(array_key_exists($k,static::$modules))
            {
                $class_name = static::$modules[$k];
                if(version_compare($class_name::$version,$v::$version) > 0){
                    static::$modules[$k] = $v;
                }
            }else {
                static::$modules[$k] = $v;
            }
        }
    }

    public static function layout(BaseCrudModule $crudModule,$layouts = []){
        foreach ($layouts as $name => $layout){
            $com = static::component($name);
            $com->setData($layout);
            $com->setName($name);
            $com->setCurdModule($crudModule);
            $com->render();
        }
    }
}
