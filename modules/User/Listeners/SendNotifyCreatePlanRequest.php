<?php

    namespace Modules\User\Listeners;

    use App\Notifications\AdminChannelServices;
    use App\Notifications\PrivateChannelServices;
    use Modules\User\Events\CreatePlanRequest;

    class SendNotifyCreatePlanRequest
    {
        public function handle(CreatePlanRequest $event)
        {
            $user = $event->user;
            $data = [
                'id' =>  $user->id,
                'event'=>'CreatePlanRequest',
                'to'=>'customer',
                'name' =>  $user->display_name,
                'avatar' =>  $user->avatar_url,
                'link' => route('user.plan'),
                'type' => 'plan',
                'message' => __('Your has created a plan request')
            ];

             $user->notify(new PrivateChannelServices($data));

            $data = [
                'id' =>  $user->id,
                'event'=>'CreatePlanRequest',
                'name' =>  $user->display_name,
                'avatar' =>  $user->avatar_url,
                'to'=>'admin',
                'link' => route('user.admin.plan_report.index'),
                'type' => 'plan',
                'message' => $user->display_name.__(' has created a plan request'),

            ];
            $user->notify(new AdminChannelServices($data));

        }
    }
