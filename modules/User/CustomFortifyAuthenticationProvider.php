<?php


namespace Modules\User;


use App\Helpers\ReCaptchaEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;

class CustomFortifyAuthenticationProvider extends ServiceProvider
{

    public function boot(){

    }

    public function register()
    {
        $this->app->bind(\Laravel\Fortify\Http\Requests\LoginRequest::class, \Modules\User\Fortify\LoginRequest::class);
    }

}
