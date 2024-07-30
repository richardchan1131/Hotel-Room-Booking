<?php

namespace Modules\User\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\User\Models\Plan;
use Modules\User\Models\UserPlan;

class PlanReportController extends AdminController
{
    protected $planClass;
    protected $userPlanClass;

    public function __construct()
    {
        $this->setActiveMenu(route('user.admin.plan.index'));
        $this->userPlanClass = UserPlan::class;
        $this->planClass = Plan::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('dashboard_access');
        $rows = $this->userPlanClass::query();
        if (!empty($plan_id = $request->query('plan_id'))) {
            $rows->where('plan_id', $plan_id);
        }
        if (!empty($create_user = $request->query('create_user'))) {
            $rows->where('user_id', $create_user);
        }
        $rows->with(['user', 'plan'])->orderBy('id', 'desc');
        $data = [
            'rows'        => $rows->paginate(20),
            'plans'       => $this->planClass::where('status', 'publish')->get(),
            'breadcrumbs' => [
                [
                    'name'  => __('User Plans'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Plan Report")
        ];
        return view('User::admin.plan-report.index', $data);
    }

    public function bulkEdit(Request $request)
    {
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
}
