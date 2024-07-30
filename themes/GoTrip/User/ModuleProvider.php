<?php

namespace Themes\GoTrip\User;

use Illuminate\Support\ServiceProvider;
use Modules\User\Controllers\UserController;

class ModuleProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(UserController::class, \Themes\GoTrip\User\Controllers\UserController::class);
    }

}
