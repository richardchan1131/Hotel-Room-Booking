<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2019
 * Time: 1:56 PM
 */
namespace Modules\Popup\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Popup\Models\Popup;
use Modules\Popup\Models\PopupTerm;
use Modules\Popup\Models\PopupTranslation;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Core\Models\Attributes;
use Modules\Location\Models\Location;

class PopupController extends AdminController
{
    protected $popup;
    protected $popup_translation;

    public function __construct()
    {
        $this->setActiveMenu(route('popup.admin.index'));
        $this->popup = Popup::class;
        $this->popup_translation = PopupTranslation::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('popup_view');
        $query = $this->popup::query();
        $query->orderBy('id', 'desc');
        if (!empty($s = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $s . '%');
            $query->orderBy('title', 'asc');
        }
        $data = [
            'rows'              => $query->paginate(20),
            'breadcrumbs'       => [
                [
                    'name' => __('Popups'),
                    'url'  => route('popup.admin.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Popup Management")
        ];
        return view('Popup::admin.index', $data);
    }

    public function recovery(Request $request)
    {
        $this->checkPermission('popup_view');
        $query = $this->popup::onlyTrashed();
        $query->orderBy('id', 'desc');
        if (!empty($s = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $s . '%');
            $query->orderBy('title', 'asc');
        }

        $data = [
            'rows'              => $query->with(['author'])->paginate(20),
            'recovery'          => 1,
            'breadcrumbs'       => [
                [
                    'name' => __('Popups'),
                    'url'  => route('popup.admin.index')
                ],
                [
                    'name'  => __('Recovery'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Recovery Popup Management")
        ];
        return view('Popup::admin.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('popup_create');
        $row = new $this->popup();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'          => $row,
            'translation'  => new $this->popup_translation(),
            'breadcrumbs'  => [
                [
                    'name' => __('Popups'),
                    'url'  => route('popup.admin.index')
                ],
                [
                    'name'  => __('Add Popup'),
                    'class' => 'active'
                ],
            ],
            'page_title'   => __("Add new Popup")
        ];
        return view('Popup::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('popup_update');
        $row = $this->popup::find($id);
        if (empty($row)) {
            return redirect(route('popup.admin.index'));
        }
        $translation = $row->translate($request->query('lang',get_main_lang()));
        $data = [
            'row'               => $row,
            'translation'       => $translation,
            'enable_multi_lang' => true,
            'breadcrumbs'       => [
                [
                    'name' => __('Popups'),
                    'url'  => route('popup.admin.index')
                ],
                [
                    'name'  => __('Edit Popup'),
                    'class' => 'active'
                ],
            ],
            'page_title'        => __("Edit: :name", ['name' => $row->title])
        ];
        return view('Popup::admin.detail', $data);
    }

    public function store(Request $request, $id)
    {

        if(is_demo_mode()){
            return back()->with("error","DEMO MODE: You are not allowed to change data");
        }

        if ($id > 0) {
            $this->checkPermission('popup_update');
            $row = $this->popup::find($id);
            if (empty($row)) {
                return redirect(route('popup.admin.index'));
            }
        } else {
            $this->checkPermission('popup_create');
            $row = new $this->popup();
        }
        $dataKeys = [
            'title',
            'content',
            'include_url',
            'exclude_url',
            'schedule_type',
            'schedule_amount',
            'status'
        ];

        $row->fillByAttr($dataKeys, $request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'), true);
        if ($res) {

            if ($id > 0) {
                return back()->with('success', __('Popup updated'));
            } else {
                return redirect(route('popup.admin.edit', $row->id))->with('success', __('Popup created'));
            }
        }
    }

    public function bulkEdit(Request $request)
    {

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        switch ($action) {
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->popup::where("id", $id);
                    $this->checkPermission('popup_delete');
                    $row = $query->first();
                    if (!empty($row)) {
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "permanently_delete":
                foreach ($ids as $id) {
                    $query = $this->popup::where("id", $id);
                    $this->checkPermission('popup_delete');
                    $row = $query->withTrashed()->first();
                    if ($row) {
                        $row->forceDelete();
                    }
                }
                return redirect()->back()->with('success', __('Permanently delete success!'));
                break;
            case "recovery":
                foreach ($ids as $id) {
                    $query = $this->popup::withTrashed()->where("id", $id);
                    $row = $query->first();
                    if (!empty($row)) {
                        $row->restore();
                    }
                }
                return redirect()->back()->with('success', __('Recovery success!'));
                break;
            case "clone":
                $this->checkPermission('popup_create');
                foreach ($ids as $id) {
                    (new $this->popup())->saveCloneByID($id);
                }
                return redirect()->back()->with('success', __('Clone success!'));
                break;
            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->popup::where("id", $id);
                    $this->checkPermission('popup_update');
                    $row = $query->first();
                    $row->status = $action;
                    $row->save();
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }

}
