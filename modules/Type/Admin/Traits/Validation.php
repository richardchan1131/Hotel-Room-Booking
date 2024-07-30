<?php

namespace Modules\Type\Admin\Traits;

use Modules\Type\Enum\ActionProp;
use Modules\Type\Enum\Permission;

trait Validation
{

    public function validateType(string $type){
        $typeObj = $this->type_manager->type($type);
        if(!$typeObj){
            abort(404);
        }
        $this->type = $typeObj;
    }

    public function validateTypeAttribute(string $type){
        $this->validateType($type);

        if(!$this->type->hasAttribute()){
            abort(404);
        }
    }

    public function validatePermission(string $action){
        $actionData = $this->type->adminAction($action);

        if($per = $actionData[ActionProp::PERMISSION]){
            $this->checkPermission($per);
        }
    }
    public function validatePermissionAttribute(){
        $this->checkPermission($this->type->permissions[Permission::MANAGE]);
    }

}
