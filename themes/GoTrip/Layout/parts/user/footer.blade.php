<footer class="footer -dashboard mt-60">
    <div class="footer__row row y-gap-10 items-center justify-between">
        <div class="col-auto">
            <div class="row y-gap-20 items-center">
                <div class="col-auto">
                    <div class="text-14 lh-14 mr-30">
                        {!! setting_item_with_lang("footer_text_left") ?? ''  !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-auto">
            <div class="d-flex x-gap-5 y-gap-5 items-center">

            </div>
        </div>
    </div>
</footer>

@include('Popup::frontend.popup')
@if(Auth::id())
    @include('Media::browser')
@endif

<!-- Custom script for all pages -->
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/jquery-3.6.3.min.js') }}"></script>

{!! App\Helpers\MapEngine::scripts() !!}

<script src="{{ asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/libs/bs/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/vendors.js')}}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/main.js')}}"></script>
<script src="{{ asset('libs/pusher.min.js') }}"></script>

@if(Auth::id())
    <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset('libs/carousel-2/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/moment.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('module/user/js/user.js?_ver='.config('app.asset_version')) }}"></script>
@if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable']))
    <div class="booking_cookie_agreement p-3 d-flex fixed-bottom">
        <div class="content-cookie">{!! clean(setting_item_with_lang('cookie_agreement_content')) !!}</div>
        <button class="btn save-cookie">{!! clean(setting_item_with_lang('cookie_agreement_button_text')) !!}</button>
    </div>
    <script>
        var save_cookie_url = '{{route('core.cookie.check')}}';
    </script>
    <script src="{{ asset('js/cookie.js?_ver='.config('app.version')) }}"></script>
@endif

{{-- home.js --}}
<script src="{{ asset('themes/gotrip/dist/frontend/js/gotrip.js?_ver='.config('app.version')) }}"></script>

@php \App\Helpers\ReCaptchaEngine::scripts() @endphp
@if(setting_item('user_enable_2fa'))
    @include('auth.confirm-password-modal')
    <script src="{{asset('/module/user/js/2fa.js')}}"></script>
@endif
@stack('js')

