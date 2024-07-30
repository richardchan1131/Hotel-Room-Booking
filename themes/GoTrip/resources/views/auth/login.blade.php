@extends('layouts.app')

@section('content')
<div class="layout-pt-lg layout-pb-lg bg-blue-2 header-margin">
    <div class="container">
        <div class="row justify-center bravo-login-form-page bravo-login-page">
            <div class="col-xl-6 col-lg-7 col-md-9">
                @include('Layout::admin.message')
                <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                    <div class="row">
                        @include('Layout::auth.login-form',['captcha_action'=>'login_normal'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
