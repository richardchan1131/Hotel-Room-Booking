<?php


namespace Modules\User\Listeners;


use Illuminate\Auth\Events\PasswordReset;

class ClearUserTokens
{
    public function handle(PasswordReset $event)
    {
        $user = $event->user;
        if($user){

            $user->need_update_pw = 0;
            $user->save();

            $user->tokens()->delete();
        }
    }
}
