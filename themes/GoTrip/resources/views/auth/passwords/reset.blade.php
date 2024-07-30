@extends('layouts.app')

@section('content')
    <div class="layout-pt-lg layout-pb-lg bg-blue-2 header-margin">
        <div class="container">
            <div class="row justify-content-center bravo-login-form-page bravo-login-page">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                        <h4 class="form-title text-22 fw-500 mb-3">{{ __('Reset Password') }}</h4>
                        <div class="row">

                            <form method="POST" action="{{ route('password.update') }}" class="y-gap-20">
                                @include('Layout::admin.message')
                                @csrf
                                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                                <div class="col-12">
                                    <div class="form-input">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email',request()->email) }}" required autofocus>
                                        <label class="lh-1 text-14 text-light-1">{{ __('E-Mail Address') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input">
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        <label class="lh-1 text-14 text-light-1">{{ __('Password') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        <label class="lh-1 text-14 text-light-1">{{ __('Confirm Password') }}</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="button py-20 -dark-1 bg-blue-1 text-white w-100 form-submit">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
