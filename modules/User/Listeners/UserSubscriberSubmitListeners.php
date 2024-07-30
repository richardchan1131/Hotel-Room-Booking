<?php

namespace Modules\User\Listeners;

use App\Notifications\AdminChannelServices;
use App\Notifications\PrivateChannelServices;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Modules\User\Events\NewVendorRegistered;
use Modules\User\Events\RequestCreditPurchase;
use Modules\User\Events\UserSubscriberSubmit;
use Modules\User\Events\VendorApproved;

class UserSubscriberSubmitListeners
{

    public function handle(UserSubscriberSubmit $event)
    {
        $subscriber = $event->subscriber;
        $data = [
            'id' =>  $subscriber->id,
            'event'=>'UserSubscriberSubmit',
            'to'=>'admin',
            'name' =>  __('Someone'),
            'avatar' =>  '',
            'link' => route('user.admin.subscriber.index'),
            'type' => 'subscriber',
            'message' => __('You have just gotten a new Subscriber')
        ];

        $user = User::query()->select("users.*")->hasPermission("dashboard_access")->first();

        if($user){
            $user->notify(new AdminChannelServices($data));
        }

    }
}
