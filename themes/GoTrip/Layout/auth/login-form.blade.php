<form class="bravo-theme-gotrip-login-form y-gap-20" method="POST" action="{{ route('login') }}">
    <input type="hidden" name="redirect" value="{{request()->query('redirect')}}">
    @csrf
    <div class="col-12">
        <h4 class="form-title text-22 fw-500">{{ __('Welcome back') }}</h4>
        @if(is_enable_registration())
            <p class="mt-10">{{ __("Don't have an account yet?") }} <a data-bs-toggle="modal" href="#register" class="text-blue-1">{{ __('Sign up for free') }}</a></p>
        @endif
    </div>
    <div class="col-12">
        <div class="form-input">
            <input type="text" name="email" autocomplete="off">
            <label class="lh-1 text-14 text-light-1">{{ __('Email') }}</label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-input">
            <input type="password" name="password" autocomplete="off">
            <label class="lh-1 text-14 text-light-1">{{ __('Password') }}</label>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-between">
        <div class="d-flex ">
            <div class="form-checkbox" style="margin-top: 3px">
                <input type="checkbox" name="remember" id="remember-me" value="1">
                <div class="form-checkbox__mark">
                    <div class="form-checkbox__icon icon-check"></div>
                </div>
            </div>
            <div class="text-15 lh-15 text-light-1 ml-10">{{__('Remember me')}}</div>
        </div>
        <a href="{{ route("password.request") }}">{{__('Forgot Password?')}}</a>
    </div>
    @if(setting_item("user_enable_login_recaptcha"))
        <div class="col-12">
            <div class="form-group">
                {{recaptcha_field($captcha_action ?? 'login')}}
            </div>
        </div>
    @endif
    <div class="error message-error invalid-feedback"></div>
    <div class="col-12">
        <button class="button py-20 -dark-1 bg-blue-1 text-white w-100 form-submit" type="submit">
            {{ __('Sign In') }}
            <div class="icon-arrow-top-right ml-15"></div>
            <span class="spinner-grow spinner-grow-sm icon-loading ml-15 d-none" role="status" aria-hidden="true"></span>
        </button>
    </div>
    @if(setting_item('facebook_enable') or setting_item('google_enable') or setting_item('twitter_enable'))
        <div class="advanced y-gap-20">
            <div class="col-12">
                <div class="text-center">{{__('or sign in with')}}</div>
                @if(setting_item('facebook_enable'))
                    <a href="{{url('/social-login/facebook')}}" class="button col-12 -outline-blue-1 text-blue-1 py-15 rounded-8 mt-10 cursor-pointer">
                        <i class="fa fa-facebook text-15 mr-10"></i>
                        {{__('Facebook')}}
                    </a>
                @endif
                @if(setting_item('google_enable'))
                    <a href="{{url('social-login/google')}}" class="button col-12 -outline-red-1 text-red-1 py-15 rounded-8 mt-15 cursor-pointer" data-channel="google">
                        <i class="fa fa-google text-15 mr-10"></i>
                        {{__('Google')}}
                    </a>
                @endif
                @if(setting_item('twitter_enable'))
                    <a href="{{url('social-login/twitter')}}" class="button col-12 -outline-dark-2 text-dark-2 py-15 rounded-8 mt-15 cursor-pointer" data-channel="twitter">
                        <i class="fa fa-twitter text-15 mr-10"></i>
                        {{__('Twitter')}}
                    </a>
                @endif
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="text-center px-30">{{ __('By creating an account, you agree to our Terms of Service and Privacy Statement.') }}</div>
    </div>
</form>
