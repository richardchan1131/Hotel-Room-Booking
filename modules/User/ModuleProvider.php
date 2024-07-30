<?php
namespace Modules\User;
use App\Helpers\ReCaptchaEngine;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Modules\ModuleServiceProvider;
use Modules\User\Chatify\ChatifyMessenger;
use Modules\User\Models\Plan;
use Modules\User\Models\PlanPayment;
use Modules\Vendor\Models\VendorRequest;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CustomFortifyAuthenticationProvider::class);

        $this->app->bind('ChatifyMessenger', function () {
            return new ChatifyMessenger();
        });
    }

    public static function getPayableServices()
    {
        return ['plan'=>Plan::class];
    }

    public static function getAdminMenu()
    {
        $noti_verify = User::countVerifyRequest();
        $noti_upgrade = VendorRequest::where('status', 'pending')->whereHas('user')->count();
        $noti = $noti_verify;

        $options = [
            "position" => 10,
            'url'        => route('user.admin.index'),
            'title'      => __('Users :count',['count'=>$noti ? sprintf('<span class="badge badge-warning">%d</span>',$noti) : '']),
            'icon'       => 'icon ion-ios-contacts',
            'permission' => 'user_view',
            'group'    => 'system',
            'children'   => [
                'user'=>[
                    'url'   => route('user.admin.index'),
                    'title' => __('All Users'),
                    'icon'  => 'fa fa-user',
                ],
                'role'=>[
                    'url'        => route('user.admin.role.index'),
                    'title'      => __('Role Manager'),
                    'permission' => 'role_view',
                    'icon'       => 'fa fa-lock',
                ],
                'subscriber'=>[
                    'url'        => route('user.admin.subscriber.index'),
                    'title'      => __('Subscribers'),
                    'permission' => 'newsletter_manage',
                ],
                'userUpgradeRequest'=>[
                    'url'        => route('user.admin.upgrade'),
                    'title'      => __('Upgrade Request :count',['count'=>$noti_upgrade ? sprintf('<span class="badge badge-warning">%d</span>',$noti_upgrade) : '']),
                    'permission' => 'user_view',
                ],
            ]
        ];

        $is_disable_verification_feature = setting_item('user_disable_verification_feature');
        if(empty($is_disable_verification_feature)){
            $options['children']['user_verification'] = [
                'url'        => route('user.admin.verification.index'),
                'title'      => __('Verification Request :count',['count'=>$noti_verify ? sprintf('<span class="badge badge-warning">%d</span>',$noti_verify) : '']),
                'permission' => 'user_view',
            ];
        }


        $count = PlanPayment::query()->where('object_model','plan')->where('status','processing')->count();
        return [
            'users'=> $options,
            'plan'=>[
                "position"=>50,
                'url'        => route('user.admin.plan.index'),
                'title'      => __('User Plans :count',['count'=>$count ? sprintf('<span class="badge badge-warning">%d</span>',$count) : '']),
                'icon'       => 'fa fa-list-alt',
                'permission' => 'role_view',
                'group' => 'system',
                'children'   => [
                    'user-plan'=>[
                        'url'   => route('user.admin.plan.index'),
                        'title' => __('User Plans'),
                        'permission' => 'role_view',
                    ],
                    'plan-report'=>[
                        'url'        => route('user.admin.plan_report.index'),
                        'title'      => __('Plan Report'),
                        'permission' => 'role_view',
                    ],
                    'plan-request'=>[
                        'url'        => route('user.admin.plan_request.index'),
                        'title'      => __('Plan Request :count',['count'=>$count ? sprintf('<span class="badge badge-warning">%d</span>',$count) : '']),
                        'permission' => 'role_view',
                    ],
                ]
            ]
        ];
    }
    public static function getUserMenu()
    {
        /**
         * @var $user User
         */
        $res = [];
        $user = Auth::user();

        $is_wallet_module_disable = setting_item('wallet_module_disable');
        if (empty($is_wallet_module_disable) and isPro())
        {
            $res['wallet']= [
                'position'   => 85,
                'icon'       => 'fa fa-money',
                'url'        => route('user.wallet'),
                'title'      => __("My Wallet"),
            ];
        }

        $is_disable_verification_feature = setting_item('user_disable_verification_feature');
        if(!empty($user->verification_fields) and empty($is_disable_verification_feature))
        {
            $res['verification']= [
                'url'        => route('user.verification.index'),
                'title'      => __("Verifications"),
                'icon'       => 'fa fa-handshake-o',
                'position'   => 85,
            ];
        }

        if(setting_item('inbox_enable')) {
            $count = auth()->user()->unseen_message_count;
            $res['chat'] = [
                'position' => 90,
                'icon' => 'fa fa-comments',
                'url' => route('user.chat'),
                'title' => __("Messages :count",['count'=>$count ? sprintf('<span class="badge badge-danger">%d</span>',$count) : '']),
            ];
        }
        if(setting_item('user_enable_2fa'))
        {
            $res['chat'] = [
                'position' => 110,
                'icon' => 'fa fa-lock',
                'url' => route('user.2fa'),
                'title' => __("2F Authentication"),
            ];
        }

        if(is_enable_plan())
        $res['my_plan'] = [
            'url' => 'user/my-plan',
            'title' => __("My Plans"),
            'icon' => 'fa fa-list-alt',
            'permission' => 'dashboard_vendor_access',
            'enable' => true,
            'position' => 95,
        ];

        return $res;
    }


}
