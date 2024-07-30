<?php
namespace Modules\User;


use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Events\AdminUpdateVerificationData;
use Modules\User\Events\CreatePlanRequest;
use Modules\User\Events\RequestCreditPurchase;
use Modules\User\Events\UpdateCreditPurchase;
use Modules\User\Events\UpdatePlanRequest;
use Modules\User\Events\UserSubscriberSubmit;
use Modules\User\Events\UserVerificationSubmit;
use Modules\User\Listeners\ClearUserTokens;
use Modules\User\Listeners\SendAdminUpdateVerifyDataEmail;
use Modules\User\Listeners\SendNotifyCreatePlanRequest;
use Modules\User\Listeners\SendNotifyRequestCreditPurchase;
use Modules\User\Listeners\SendNotifyUpdateCreditPurchase;
use Modules\User\Listeners\SendNotifyUpdatePlanRequest;
use Modules\User\Listeners\SendNotifyUpdateVerificationData;
use Modules\User\Listeners\SendNotifyVerificationData;
use Modules\User\Listeners\SendUserSubmitVerifyDataEmail;
use Modules\User\Listeners\UserSubscriberSubmitListeners;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserVerificationSubmit::class => [
            SendUserSubmitVerifyDataEmail::class,
            SendNotifyVerificationData::class
        ],
        AdminUpdateVerificationData::class => [
            SendAdminUpdateVerifyDataEmail::class,
            SendNotifyUpdateVerificationData::class
        ],
        RequestCreditPurchase::class => [
            SendNotifyRequestCreditPurchase::class
        ],
        UpdateCreditPurchase::class => [
            SendNotifyUpdateCreditPurchase::class
        ],
        UserSubscriberSubmit::class => [
            UserSubscriberSubmitListeners::class
        ],
        PasswordReset::class=>[
            ClearUserTokens::class
        ],
        CreatePlanRequest::class => [
            SendNotifyCreatePlanRequest::class
        ],
        UpdatePlanRequest::class => [
            SendNotifyUpdatePlanRequest::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
