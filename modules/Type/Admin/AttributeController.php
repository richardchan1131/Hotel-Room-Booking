<?php
namespace Modules\Type\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\AdminController;
use Modules\Core\Models\Attributes;
use Modules\Core\Models\AttributesTranslation;
use Modules\Core\Models\Terms;
use Modules\Core\Models\TermsTranslation;
use Modules\Type\Abstracts\BaseType;
use Modules\Type\Admin\Traits\Validation;
use Modules\Type\TypeManager;

class AttributeController extends AdminController
{
    use Validation;

    /**
     * @var TypeManager
     */
    public TypeManager $type_manager;
    /**
     * @var Attributes
     */
    public Attributes $attributes;

    /**
     * @var BaseType
     */
    public BaseType $type;
    /**
     * @var Terms
     */
    public Terms $terms;
    /**
     * @var TermsTranslation
     */
    public TermsTranslation $terms_translation;

    public function __construct(TypeManager $type_manager,Attributes $attributes,Terms $terms,TermsTranslation $terms_translation)
    {
        $this->type_manager = $type_manager;
        $this->attributes = $attributes;

        if(Route::current()){
            $this->setActiveMenu(route('type.admin.index',['type'=>Route::current()->parameter('type')]));
        }
        $this->terms = $terms;
        $this->terms_translation = $terms_translation;
    }


    public function index(Request $request,string $type)
    {
        $this->validateTypeAttribute($type);

        $this->validatePermissionAttribute();

        $listAttr = $this->attributes::where("service", $type);
        if (!empty($search = $request->query('s'))) {
            $listAttr->where('name', 'LIKE', '%' . $search . '%');
        }
        $listAttr->orderBy('created_at', 'desc');
        $data = [
            'rows'        => $listAttr->get(),
            'row'         => new $this->attributes(),
            'translation'    => new AttributesTranslation(),
            'breadcrumbs' => [
                [
                    'name' => __(":type Management",['type'=>$this->type->getName()]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name'  => __('Attributes'),
                    'class' => 'active'
                ],
            ],
            'typeId'=>$type,
            'typeName'=>$this->type->getName()
        ];
        return view('Type::admin.attribute.index', $data);
    }

    public function edit(Request $request, $type, $id)
    {
        $this->validateTypeAttribute($type);

        $this->validatePermissionAttribute();

        $row = $this->attributes::find($id);
        if (empty($row)) {
            return redirect()->back()->with('error', __('Attributes not found!'));
        }
        $translation = $row->translate($request->query('lang',get_main_lang()));
        $data = [
            'translation'    => $translation,
            'enable_multi_lang'=>true,
            'rows'        => $this->attributes::where("service", 'tour')->get(),
            'row'         => $row,
            'breadcrumbs' => [
                [
                    'name' => __(":type Management",['type'=>$this->type->getName()]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name' => __('Attributes'),
                    'url'  => route('type.admin.attribute.index',['type'=>$type])
                ],
                [
                    'name'  => __('Attribute: :name', ['name' => $row->name]),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Type::admin.attribute.detail', $data);
    }

    public function store(Request $request,$type)
    {
        $this->validateTypeAttribute($type);

        $this->validatePermissionAttribute();

        $this->validate($request, [
            'name' => 'required'
        ]);
        $id = $request->input('id');
        if ($id) {
            $row = $this->attributes::find($id);
            if (empty($row)) {
                return redirect()->back()->with('error', __('Attribute not found!'));
            }
        } else {
            $row = new $this->attributes($request->input());
            $row->service = $type;
        }
        $row->fill($request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'));
        if ($res) {
            return redirect()->back()->with('success', __('Attribute saved'));
        }
    }

    public function editAttrBulk(Request $request,string $type)
    {
        $this->validateTypeAttribute($type);

        $this->validatePermissionAttribute();

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $this->attributes::where("id", $id);
                $query->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

    public function terms(Request $request,string $type, $attr_id)
    {
        $this->validateTypeAttribute($type);
        $this->validatePermissionAttribute();

        $termClass = $this->terms;
        $termTranslationClass = $this->terms_translation;

        $row = $this->attributes::find($attr_id);
        if (empty($row)) {
            return redirect()->back()->with('error', __('Term not found!'));
        }
        $listTerms = $termClass::where("attr_id", $attr_id);
        if (!empty($search = $request->query('s'))) {
            $listTerms->where('name', 'LIKE', '%' . $search . '%');
        }
        $listTerms->orderBy('created_at', 'desc');
        $data = [
            'rows'        => $listTerms->paginate(20),
            'attr'        => $row,
            "row"         => new $termClass,
            'translation'    => new $termTranslationClass,
            'breadcrumbs' => [
                [
                    'name' => __(":type Management",['type'=>$this->type->getName()]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name' => __('Attributes'),
                    'url'  => route('type.admin.attribute.index',['type'=>$type])
                ],
                [
                    'name' => $row->name,
                    'class' => 'active'
                ],
            ]
        ];
        return view('Type::admin.terms.index', $data);
    }

    public function term_edit(Request $request,string $type, $id)
    {
        $this->validateTypeAttribute($type);
        $this->validatePermissionAttribute();
        $termClass = $this->terms;

        $row = $termClass::find($id);
        if (empty($row)) {
            return redirect()->back()->with('error', __('Term not found'));
        }
        $translation = $row->translate($request->query('lang',get_main_lang()));
        $attr = $this->attributes::find($row->attr_id);
        $data = [
            'row'         => $row,
            'translation'    => $translation,
            'enable_multi_lang'=>true,
            'breadcrumbs' => [
                [
                    'name' => __(":type Management",['type'=>$this->type->getName()]),
                    'url'  => route('type.admin.index',['type'=>$type])
                ],
                [
                    'name' => __('Attributes'),
                    'url'  => route('type.admin.attribute.index',['type'=>$type])
                ],
                [
                    'name' => $attr->name,
                    'url'  => route('type.admin.attribute.term.index',['type'=>$type,'attr_id'=>$row->attr_id])
                ],
                [
                    'name'  => __('Term: :name', ['name' => $row->name]),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Type::admin.terms.detail', $data);
    }

    public function term_store(Request $request,string $type)
    {
        $this->validateTypeAttribute($type);
        $this->validatePermissionAttribute();
        $termClass = $this->terms;

        $this->validate($request, [
            'name' => 'required'
        ]);
        $id = $request->input('id');
        if ($id) {
            $row = $termClass::find($id);
            if (empty($row)) {
                return redirect()->back()->with('error', __('Term not found!'));
            }
        } else {
            $row = new $termClass($request->input());
            $row->attr_id = $request->input('attr_id');
        }
        $row->fill($request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'));
        if ($res) {
            return redirect()->back()->with('success', __('Term saved'));
        }
    }

    public function editTermBulk(Request $request,string $type)
    {
        $this->validateTypeAttribute($type);
        $this->validatePermissionAttribute();
        $termClass = $this->terms;

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $termClass::where("id", $id);
                $query->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

}
