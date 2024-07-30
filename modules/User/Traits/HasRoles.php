<?php


namespace Modules\User\Traits;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;
use Modules\User\Models\RolePermission;

trait HasRoles
{
    /**
     * Check User has Permission
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission = ''){

        if(!$this->role or !$this->role->hasPermission($permission)) return false;

        return true;
    }

    /**
     * Assign Role for User
     *
     * @param String|Role $role_id
     */
    public function assignRole($role_id){
        if($role_id instanceof Role){
            $this->role_id = $role_id->id;
            $this->save();
        }

        $role = Role::find((int)$role_id);
        if(empty($role)){
            $role = Role::query()->where('code',$role_id)->first();
        }
        if(empty($role)){
            $role = Role::query()->where('name',$role_id)->first();
        }

        if($role){
            $this->role_id = $role->id;
            $this->save();
        }
    }

    protected function roleName():Attribute{
        return Attribute::make(
          get:function(){
                  return $this->role->name ?? '';
            }
        );
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function scopeRole($query,$role_id){
        if(is_string($role_id)){
            $role = Role::find($role_id);
            if($role){
                return $query->where('role_id',$role->id);
            }
        }
        return $query->where('role_id',$role_id);
    }

    public function hasRole($role_id){
        if($role_id instanceof Role){
           return $this->role_id == $role_id->id;
        }
        if(is_integer($role_id)){
            return $this->role_id == $role_id;
        }
        $role = Role::query()->where('code',$role_id)->first();
        if(empty($role)){
            $role = Role::query()->where('name',$role_id)->first();
        }

        return $this->role_id == $role->id;
    }

    public function scopeHasPermission($query,$permission){
        $query->join('core_role_permissions',function($join) use ($permission){
            $join->on('core_role_permissions.role_id','users.role_id');
            $join->where('core_role_permissions.permission',$permission);
            return $join;
        });
        return $query;
    }
}
