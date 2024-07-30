<?php

namespace Modules\User\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\User\Models\Plan;
use Modules\User\Models\PlanTranslation;

class PlanController extends AdminController
{
    protected $planClass;

    public function __construct()
    {
        $this->setActiveMenu(route('user.admin.plan.index'));
        $this->planClass = Plan::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('dashboard_access');
        $rows = $this->planClass::query();
        if (!empty($search = $request->query('s'))) {
            $rows->where('title', 'LIKE', '%' . $search . '%');
        }
        $rows->orderBy('id', 'desc');
        $data = [
            'rows'        => $rows->paginate(20),
            'row'         => new $this->planClass(),
            'translation' => new PlanTranslation(),
            'breadcrumbs' => [
                [
                    'name'  => __('User Plans'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("User Plan Management")
        ];
        return view('User::admin.plan.index', $data);
    }


    public function edit(Request $request, $id)
    {
        $this->checkPermission('dashboard_access');
        $row = $this->planClass::find($id);
        if (empty($row)) {
            return redirect(route('user.admin.plan.index'));
        }
        $translation = $row->translate($request->query('lang', get_main_lang()));
        $data = [
            'translation'       => $translation,
            'enable_multi_lang' => true,
            'row'               => $row,
            'breadcrumbs'       => [
                [
                    'name'  => __('User Plans'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Edit user plan")
        ];
        return view('User::admin.plan.detail', $data);
    }

    public function store(Request $request, $id)
    {
        if (is_demo_mode()) {
            return back()->with('error', "Demo mode: disabled");
        }
        $this->checkPermission('dashboard_access');
        $this->validate($request, [
            'title'         => 'required',
            'role_id'       => 'required',
            'duration'      => 'required',
            'duration_type' => 'required',
        ]);

        if ($id > 0) {
            $row = $this->planClass::find($id);
            if (empty($row)) {
                return redirect(route('user.admin.plan.index'));
            }
        } else {
            $row = new $this->planClass();
        }

        $row->fillByAttr([
            'title',
            'content',
            'price',
            'duration',
            'duration_type',
            'max_service',
            'status',
            'role_id',
            'annual_price',
            'image_id'
        ], $request->input());

        $res = $row->saveOriginOrTranslation($request->input('lang'));

        if ($res) {
            return back()->with('success', __('Plan saved'));
        }
    }

    public function bulkEdit(Request $request)
    {
        if (is_demo_mode()) {
            return back()->with('error', "Demo mode: disabled");
        }
        $this->checkPermission('dashboard_access');
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
                $query = $this->planClass::where("id", $id)->first();
                if (!empty($query)) {
                    //Del parent category
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->planClass::where("id", $id);
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if ($pre_selected && $selected) {
            $items = $this->planClass::find($selected);


            return [
                'results' => $items
            ];
        }
        $q = $request->query('q');
        $query = $this->planClass::select('id', 'title as text')->where("status", "publish");
        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
