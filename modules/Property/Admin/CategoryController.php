<?php
namespace Modules\Property\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Property\Models\PropertyCategory;
use Modules\Property\Models\PropertyCategoryTranslation;

class CategoryController extends AdminController
{
    protected $propertyCategoryClass;

    public function __construct(PropertyCategory $propertyCategoryClass)
    {
        $this->setActiveMenu('admin/module/property');
        $this->propertyCategoryClass = $propertyCategoryClass;
    }

    public function index(Request $request)
    {
        $this->checkPermission('property_manage_others');
        $listCategory = $this->propertyCategoryClass::query();
        if (!empty($search = $request->query('s'))) {
            $listCategory->where('name', 'LIKE', '%' . $search . '%');
        }
        $listCategory->orderBy('created_at', 'desc');
        $data = [
            'rows'        => $listCategory->get()->toTree(),
            'row'         => new $this->propertyCategoryClass(),
            'translation'    => new PropertyCategoryTranslation(),
            'breadcrumbs' => [
                [
                    'name' => __('Property'),
                    'url'  => 'admin/module/property'
                ],
                [
                    'name'  => __('Category'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Property::admin.category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('property_manage_others');
        $row = $this->propertyCategoryClass::find($id);
        if (empty($row)) {
            return redirect(route('property.admin.category.index'));
        }
        $translation = $row->translate($request->query('lang'));
        $data = [
            'translation'    => $translation,
            'enable_multi_lang'=>true,
            'row'         => $row,
            'parents'     => $this->propertyCategoryClass::get()->toTree(),
            'breadcrumbs' => [
                [
                    'name' => __('Property'),
                    'url'  => 'admin/module/property'
                ],
                [
                    'name'  => __('Category'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Property::admin.category.detail', $data);
    }

    public function store(Request $request , $id)
    {
        $this->checkPermission('property_manage_others');
        $this->validate($request, [
            'name' => 'required'
        ]);
        if($id>0){
            $row = $this->propertyCategoryClass::find($id);
            if (empty($row)) {
                return redirect(route('property.admin.category.index'));
            }
        }else{
            $row = new $this->propertyCategoryClass();
            $row->status = "publish";
        }

        $row->fill($request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            return back()->with('success',  __('Category saved') );
        }
    }

    public function editBulk(Request $request)
    {
        $this->checkPermission('property_manage_others');
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
                $query = $this->propertyCategoryClass::where("id", $id)->first();
                if(!empty($query)){
                    //Sync child category
                    $list_childs = $this->propertyCategoryClass::where("parent_id", $id)->get();
                    if(!empty($list_childs)){
                        foreach ($list_childs as $child){
                            $child->parent_id = null;
                            $child->save();
                        }
                    }
                    //Del parent category
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->propertyCategoryClass::where("id", $id);
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            if(is_array($selected)){
                $item = $this->propertyCategoryClass::query()
                    ->select([$this->propertyCategoryClass->qualifyColumn('id'),$this->propertyCategoryClass->qualifyColumn('name as text')])
                    ->whereIn('id',$selected)->get();
            }else{
                $item = $this->propertyCategoryClass->find($selected);
            }

            return [
                'results'=> $item
            ];
        }
        $q = $request->query('q');
        $query = $this->propertyCategoryClass::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
