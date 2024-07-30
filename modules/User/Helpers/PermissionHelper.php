<?php


namespace Modules\User\Helpers;


use Illuminate\Support\Collection;

class PermissionHelper
{
    /**
     * @var Collection
     */
    protected static $all = [];

    protected static $is_initial = false;

    public static function add($permission){
        if(!static::$is_initial){
            static::load();
        }
        $permissions = $permission;
        if(!is_array($permission)) $permissions = [$permission];

        foreach ($permissions as $p){
            if(!in_array($p,static::$all)){
                static::$all[] = $p;
            }
        }
    }

    public static function all(){

        if(!static::$is_initial){
            static::load();
        }
        return static::$all;
    }

    public static function find($permission){

        if(!static::$is_initial){
            static::load();
        }

        return in_array($permission,static::$all);
    }

    protected static function load(){
        static::$all = config('permissions');
        static::$is_initial = true;
    }
}
