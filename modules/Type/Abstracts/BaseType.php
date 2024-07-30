<?php

namespace Modules\Type\Abstracts;

use App\BaseModel;
use Modules\Type\Enum\ActionProp;
use Modules\Type\Enum\AdminAction;
use Modules\Type\Enum\Label;
use Modules\Type\Interfaces\IPostType;

abstract class BaseType implements IPostType
{

    public string $id;

    public $model;

    protected bool $hasAuthor = true;
    protected bool $hasTranslation = true;
    protected bool $hasMap = true;

    protected bool $hasAttribute = true;

    public array $permissions = [];

    public function getModel(): BaseModel
    {
        return app()->make($this->model);
    }

    protected function getLabels():array {
        return [];
    }

    /**
     * @param $key
     * @return string
     */
    public function label($key):string{
        return $this->getLabels()[$key];
    }

    public function adminAction($action):array {
        return $this->adminActions()[$action];
    }

    protected function adminActions():array{
        return [
            AdminAction::VIEW =>[
                ActionProp::PERMISSION=>''
            ],
            AdminAction::EDIT =>[
                ActionProp::PERMISSION=>''
            ],
        ];
    }

    public function hasAuthor():bool {
        return $this->hasAuthor;
    }

    public function hasTranslation():bool {
        return $this->hasTranslation;
    }


    public function hasAttribute():bool {
        return $this->hasAttribute;
    }

    public function hasMap():bool {
        return $this->hasMap;
    }

    public function getRoutePrefix():string {
        return config($this->id.'.route_prefix',$this->id);
    }

    public function getName():string {

        return $this->label(Label::NAME);
    }
}
