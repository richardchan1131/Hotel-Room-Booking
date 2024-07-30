<?php


namespace Modules\User\Controllers;


use App\Helpers\ReCaptchaEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\FrontendController;
use Modules\User\Events\CreatePlanRequest;
use Modules\User\Events\UpdatePlanRequest;
use Modules\User\Models\Plan;
use Modules\User\Models\PlanPayment;
use Modules\User\Models\UserPlan;

class PlanController extends FrontendController
{
    public function index()
    {

        if (!is_enable_plan()) {
            return redirect('/');
        }
        if (!auth()->check()) {
            return redirect(route('login'));
        }
        $plans = Plan::query()->where('role_id',auth()->user()->role_id)->whereStatus('publish')->get();
        $data = ['page_title' => __('Pricing Packages'), 'plans' => $plans, 'user' => auth()->user(),];
        return view("User::frontend.plan.index", $data);
    }

    public function myPlan()
    {
        if (!is_enable_plan()) {
            return redirect('/');
        }
        if (!auth()->user()->user_plan) {
            return redirect(route('plan'));
        }
        $data = [
            'user' => auth()->user(),
            'page_title'       => __("My Plan"),
            'menu_active' => 'my_plan',
            'breadcrumbs'      => [
                [
                    'name'  => __('My plans'),
                    'class' => 'active'
                ]
            ]
        ];
        return view("User::frontend.plan.my-plan", $data);
    }

    public function buy(Request $request, $id)
    {
        if (!is_enable_plan()) {
            return redirect('/');
        }
        $plan = Plan::find($id);
        if (!$plan) return;

        $user = auth()->user();

        $plan_page = route('plan');
        $gateways = get_available_gateways();

        if ($user->role_id != $plan->role_id) {
            return redirect()->to($plan_page)->with("warning", __("This plan is not suitable for your role."));
        }


        if ($request->query('annual') and !$plan->annual_price) {
            return redirect()->to($plan_page)->with("warning", __("This plan doesn't have annual pricing"));
        }

        return view('User::frontend.plan.checkout', ['plan' => $plan, 'user' => $user, 'gateways' => $gateways]);

    }

    public function buyProcess(Request $request, $id)
    {

        $plan = Plan::find($id);
        if (!$plan) return;
        $user = auth()->user();
        $rules = [];
        $message = [];

        $payment_gateway = $request->input('payment_gateway');
        $gateways = get_payment_gateways();
        if (empty($payment_gateway)) {
            return redirect()->back()->with("error", __("Please select payment gateway"));
        }
        if (empty($payment_gateway) or empty($gateways[$payment_gateway]) or !class_exists($gateways[$payment_gateway])) {
            return redirect()->back()->with("error", __("Payment gateway not found"));
        }
        $gatewayObj = new $gateways[$payment_gateway]($payment_gateway);
        if (!$gatewayObj->isAvailable()) {
            return redirect()->back()->with("error", __("Payment gateway is not available"));
        }
        if ($gRules = $gatewayObj->getValidationRules()) {
            $rules = array_merge($rules, $gRules);
        }
        if ($gMessages = $gatewayObj->getValidationMessages()) {
            $message = array_merge($message, $gMessages);
        }

        $rules['payment_gateway'] = 'required';
        $rules['term_conditions'] = 'required';

        /**
         * Google ReCapcha
         */
        $is_api = request()->segment(1) == 'api';

        if (!$is_api and ReCaptchaEngine::isEnable() and setting_item("booking_enable_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                return redirect()->back()->with('error', __("Please verify the captcha"));
            }
        }

        $messages['term_conditions.required'] = __('Term conditions is required field');
        $messages['payment_gateway.required'] = __('Payment gateway is required field');
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            if (is_array($validator->errors()->messages())) {
                $msg = '';
                foreach ($validator->errors()->messages() as $oneMessage) {
                    $msg .= implode('<br/>', $oneMessage) . '<br/>';
                }
                return redirect()->back()->with('error', $msg);
            }
            return redirect()->back()->with('error', $validator->errors());
        }

        if (!$plan->price || $plan->price == 0) {
            // For Free
            $new_user_plan = UserPlan::query()->find($user->id);
            if (empty($new_user_plan)) {
                $new_user_plan = new UserPlan();
                $new_user_plan->id = $user->id;
            }
            $new_user_plan->plan_id = $id;
            $new_user_plan->price = $plan->price;
            $new_user_plan->start_date = date('Y-m-d H:i:s');
            $new_user_plan->end_date = date('Y-m-d H:i:s', strtotime('+ ' . $plan->duration . ' ' . $plan->duration_type));
            $new_user_plan->max_service = $plan->max_service;
            $new_user_plan->plan_data = $plan;
            $new_user_plan->user_id = \Auth::id();
            $new_user_plan->status = 1;
            $new_user_plan->save();

            event(new UpdatePlanRequest($user));

            return redirect()->route('user.plan')->with('success', __("Purchased user package successfully"));
        }
        else {
            $is_annual = !empty($request->input('annual')) ? true : false;

            $payment = new PlanPayment();
            $payment->object_model = 'plan';
            $payment->object_id = $plan->id;
            $payment->status = 'draft';
            $payment->payment_gateway = $payment_gateway;
            $payment->amount = $is_annual ? $plan->annual_price : $plan->price;
            $payment->user_id = auth()->id();

            $payment->save();

            $payment->addMeta('user_request', $user->id);
            $payment->addMeta('annual', $is_annual);

            $user->applyPlan($plan,$payment->amount,$is_annual,false);

            $res = $gatewayObj->processNormal($payment);

            $success = $res[0] ?? null;
            $message = $res[1] ?? null;
            $redirect_url = $res[2] ?? null;
            if ($success) {
                event(new CreatePlanRequest($user));


                if (empty($redirect_url) and $payment->status == 'completed') {
                    return redirect()->route('user.plan')->with($success ? "success" : "error", $message);
                }
                if ($payment->status == 'completed') $redirect_url = route('user.plan');

                if ($redirect_url) {
                    return redirect()->to($redirect_url)->with('success', $message);
                }
                return redirect()->route('user.plan.thank-you')->with("success", $message);

            }
            else {
                return redirect()->back()->with("error", $message);
            }
        }

    }

    public function thankYou(Request $request)
    {
        return view('User::frontend.plan.thankyou');
    }

}
