<?php
namespace Modules\Type\Admin;

use Illuminate\Http\Request;
use Modules\Core\Models\Attributes;
use Modules\Type\Abstracts\BaseType;
use Modules\Type\Admin\Traits\Validation;
use Modules\Type\Enum\ActionProp;
use Modules\Type\Enum\AdminAction;
use Modules\Type\Enum\Label;
use Modules\Type\TypeManager;

class TypeController extends \Modules\AdminController
{
    use Validation;

    /**
     * @var TypeManager
     */
    public TypeManager $type_manager;

    /**
     * @var BaseType
     */
    public BaseType $type;
    /**
     * @var Attributes
     */
    public Attributes $attributes;


    public function __construct(TypeManager $type_manager,Attributes $attributes)
    {
        $this->type_manager = $type_manager;

        $this->attributes = $attributes;
    }

    public function index(Request $request, $type){

        $this->validateType($type);

        $this->validatePermission(AdminAction::VIEW);

        $this->setActiveMenu(route('type.admin.index',['type'=>$type]));

        $query = $this->type->getModel()::query();

        $data = [
            'rows'=>$query->paginate(20),
            'page_title'=>__(":type Management",['type'=>$this->type->label(Label::NAME)]),
            'type'=>$this->type,
            'typeId'=>$type,
            'hasAuthor'=>$this->type->hasAuthor(),
            'breadcrumbs'       => [
                [
                    'name' => __(":type Management",['type'=>$this->type->getName()]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name'  => __('All :type',['type'=>$this->type->getName()]),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Type::admin.index',$data);
    }

    public function edit(Request $request, $type, $id){

        $this->validateType($type);

        $this->validatePermission(AdminAction::EDIT);

        $query = $this->type->getModel()::query();
        if($this->type->hasAuthor()){
            if (!$this->hasPermission($type.'_manage_others')) {
                $query->where('author_id',auth()->id());
            }
        }
        $row = $query->first();

        if(!$row){
            abort(404);
        }
        $translation = $row->translate($request->query('lang',get_main_lang()));

        $this->setActiveMenu(route('type.admin.index',['type'=>$type]));


        $data = [
            'row'=>$row,
            'page_title'=>__(":type Management",['type'=>$this->type->label(Label::NAME)]),
            'type'=>$this->type,
            'typeId'=>$type,
            'hasAuthor'=>$this->type->hasAuthor(),
            'breadcrumbs'       => [
                [
                    'name' => __(":type Management",['type'=>$this->type->label(Label::NAME)]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name'  => __('Edit :name',['name'=>$row->title]),
                    'class' => 'active'
                ],
            ],
            'typeName'=>$this->type->label(Label::NAME),
            'translation'=>$translation,
            'attributeClass'=>$this->attributes
        ];

        return view('Type::admin.edit',$data);
    }
}
