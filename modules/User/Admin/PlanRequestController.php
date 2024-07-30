<?php

namespace Modules\User\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\User\Models\Plan;
use Modules\User\Models\PlanPayment;
use Modules\User\Models\UserPlan;

class PlanRequestController extends AdminController
{
    protected $planClass;
    protected $userPlanClass;

    public function __construct()
    {
        $this->setActiveMenu(route('user.admin.plan.index'));
        $this->userPlanClass = UserPlan::class;
        $this->planClass = Plan::class;
    }


    public function index()
    {
        $query = PlanPayment::query();
        $query->where('object_model', 'plan')->with('plan')->orderBy('id', 'desc');
        if ($user_id = request()->query('user_id')) {
            $query->where('object_id', $user_id);
        }
        if ($status = request()->query('status')) {
            $query->where('status', $status);
        }

        $data = [
            'rows'        => $query->paginate(20),
            'page_title'  => __("Plan request management"),
            'breadcrumbs' => [
                [
                    'url'  => route('user.admin.index'),
                    'name' => __("Users"),
                ],
                [
                    'url'  => '#',
                    'name' => __('Plan request management'),
                ],
            ]
        ];
        return view("User::admin.plan-request.index", $data);
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids))
            return redirect()->back()->with('error', __('Select at lease 1 item!'));
        if (empty($action))
            return redirect()->back()->with('error', __('Select an Action!'));
        if ($action == 'delete') {
//            foreach ($ids as $id) {
//                $query = PlanPayment::query()->where("id", $id)->where('object_model','plan')->delete();
//            }
//            return redirect()->back()->with('success', __('Deleted successfully!'));
        } else {
            foreach ($ids as $id) {
                switch ($action) {
                    case "completed":
                        $payment = PlanPayment::find($id);
                        if ($payment->payment_gateway == 'offline_payment' and $payment->status == 'processing') {
                            $payment->markAsCompleted();
                        }
                        break;
                    case "cancelled":
                        $payment = PlanPayment::find($id);
                        if ($payment->payment_gateway == 'offline_payment' and $payment->status == 'processing') {
                            $payment->markAsCancel();
                        }
                        break;
                }
            }
        }
        return redirect()->back()->with('success', __('Updated successfully!'));
    }
}
