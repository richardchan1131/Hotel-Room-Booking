@extends('layouts.app')

@section('content')
    <div class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center bravo-login-form-page bravo-login-page">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                        @include('Layout::auth.register-form',['captcha_action'=>'register_normal'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
