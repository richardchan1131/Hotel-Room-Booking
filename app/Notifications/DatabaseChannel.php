<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;

class DatabaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            //customize here
            'for_admin' => $data['for_admin'], //<-- comes from toDatabase() Method below
            'notifiable_id'=> $notifiable->getKey(),
            'notifiable_type'=> get_class($notifiable),
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }

}
