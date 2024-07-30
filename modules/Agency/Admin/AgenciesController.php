<?php

namespace Modules\Agency\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\AdminController;
use Modules\Agency\Models\Agency;
use Illuminate\Support\Facades\DB;
use Validator;

class AgenciesController extends AdminController
{
    protected $agenciesClass;
    public function __construct()
    {
        $this->setActiveMenu('admin/module/agencies');
        $this->agenciesClass = new Agency();
    }

    public function index(Request $request)
    {
        $this->checkPermission('agencies_view');
        $keyword = $request->query('s');
        $agencies = $this->agenciesClass::query();
        if (!empty($keyword)) {
            $agencies->where('name','like', "%" . trim($keyword) . "%");
        }
        $agencies = $agencies->orderBy('id', 'desc')->paginate(5);
        $listStatus = $this->agenciesClass::getAllStatuses();
        $data = [
            'rows'        => $agencies,
            'breadcrumbs' => [
                [
                    'name' => __('Manage Agencies'),
                    'url'  => route('agencies.admin.index'),
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'listStatus' => $listStatus,
            'page_title'  => __("Manage Agencies"),
        ];
        return view('Agency::admin.agency.index', $data);
    }

    public function create($id = null, Request $request = null)
    {
        $this->checkPermission('agencies_view');
        if (empty($id)) {
            $row = new $this->agenciesClass;
        } else {
            $row = $this->agenciesClass::find($id);
            if (empty($row)) {
                return redirect()->route('agencies.admin.index')->with('error', __('Item not found'));
            }
        }
        $data = [
            'row'           => $row,
            'breadcrumbs'   => [
                [
                    'name' => __('Manage Agencies'),
                    'url'  => route('agencies.admin.index'),
                ],
                [
                    'name'  => $id ? $row->name : __('Create Agency'),
                    'class' => 'active'
                ],
            ],
            'page_title'    =>  $id ? $row->name : __("Create a Agency"),
            'enable_multi_lang'=>$id ? true : false,
            'translation'=>$row->translate(\request('lang'))
        ];
        return view('Agency::admin.agency.detail', $data);
    }

    public function store(Request $request, $id)
    {
        $this->checkPermission('agencies_create');
        if ($id > 0) {
            $row = $this->agenciesClass::find($id);
            if (empty($row)) {
                return redirect(route('agencies.admin.index'));
            }
            if(!$this->hasPermission('user_create')) {
                if ($row->author_id != Auth::id()) {
                    return redirect(route('agencies.admin.index'));
                }
            }
        } else {
            $row = new $this->agenciesClass();

        }

        $agenciesId = $id > 0 ? $id : null;
        $rules = [
            'name' => 'required|unique:bc_agencies,name,' . $agenciesId,
            'content' => 'required',
            'image_id' => 'required',
        ];
        if(!is_default_lang()){
            unset($rules['image_id']);
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (!empty($request->get('list_agent'))) {
            $check = $this->agenciesClass::checkAgentBelongAgencies($request->get('list_agent'), $agenciesId);
            if (!$check)
                return redirect()->back()->with('error', __('Agent only belong one agencies'))->withInput();
        }

        $data = $request->input();
        if (!empty($data['social'])) {
            $data['social'] = json_encode($data['social']);
        }
        $row->fill($data);
        $row->author_id = $request->input('author_id')?:\auth()->id();

        $res = $row->saveOriginOrTranslation($request->input('lang'),true);
        if (!empty($request->get('list_agent'))) {
            $row->agent()->detach();
            $row->agent()->attach($request->get('list_agent'));
        }
        if ($res) {
            if ($id > 0) {
                return redirect()->back()->with('success', __('Agency updated'));
            } else {
                return redirect()->route('agencies.admin.create',['id'=>$row->id])->with('success', __('Agency created'));
            }
        }
    }


    public function bulkEdit(Request $request)
    {
        $this->checkPermission('agencies_create');

        $ids = $request->input('ids');
        $action = $request->input('action');
        $all_statuses = $this->agenciesClass::getAllStatuses();

        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action) || !array_key_exists($action, $all_statuses)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }

        $collection = $this->agenciesClass::whereIn('id', $ids);
        DB::beginTransaction();
        try {
            switch ($action) {
                case "delete":
                    $collection->delete();
                    DB::table('bc_agencies_agent')->whereIn('agencies_id', $ids)->delete();
                    $message = __('Delete success!');
                    break;
                default:
                    // Change status
                    $collection->update(['status' => $action, 'update_user' => Auth::id()]);
                    $message = __('Update success!');
                    break;
            }
            DB::commit();
            return redirect()->back()->with('success', $message);
        } catch (\Exception $ex) {
            Log::info($ex);
            DB::rollBack();
            return redirect()->back()->with('error', __('System error'));
        }
    }
}
