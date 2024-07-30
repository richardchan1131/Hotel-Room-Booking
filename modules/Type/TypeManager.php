<?php


namespace Modules\Type;


use Modules\Type\Abstracts\BaseType;
use Modules\Type\Enum\ActionProp;
use Modules\Type\Enum\AdminAction;
use Modules\Type\Enum\Label;

class TypeManager
{

    protected array $allTypes = [];

    public function register(string $id, string $type){
        $this->allTypes[$id] = $type;
    }

    public function all(){
        return $this->allTypes;
    }

    public function type(string $typeId) : ?BaseType {
        if(!array_key_exists($typeId,$this->allTypes)) return null;
        $type = app()->make($this->allTypes[$typeId]);
        $type->id = $typeId;
        return $type;
    }

    public function adminMenus():array{
        $all = $this->all();
        $res = [];
        foreach ($all as $id=>$class){
            $type = $this->type($id);
            if(!$type) continue;
            $res[$id] = [
                "position"=>40,
                'url'        => route('type.admin.index',['type'=>$id]),
                'title'      => $type->label(Label::PLURAL),
                'icon'       => 'icon ion-md-umbrella',
                'permission' => $type->adminAction(AdminAction::VIEW)[ActionProp::PERMISSION],
            ];

            $children = [];
            if($type->hasAttribute()){
                $children[] =[
                        'title'      => __("Attributes"),
                        'url'        => route('type.admin.attribute.index',['type'=>$id]),
                    ];
            }
            if(!empty($children)){
                $children = array_merge([
                    [
                        'title'      => __("All :type",['type'=>$type->label(Label::PLURAL)]),
                        'url'        => route('type.admin.index',['type'=>$id]),
                    ],
                    [
                        'title'      => __("Create :type",['type'=>$type->label(Label::NAME)]),
                        'url'        => route('type.admin.create',['type'=>$id]),
                    ],
                ],$children);

                $res[$id]['children'] = $children;
            }
        }
        return $res;
    }
}
