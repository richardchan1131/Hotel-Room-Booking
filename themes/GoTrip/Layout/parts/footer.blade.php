<?php
$footerStyle = !empty($row->footer_style) ? $row->footer_style : setting_item('footer_style','normal');
$mailchimp_classes = "bg-dark-2";
$button_classes = "bg-blue-1 text-white";
if($footerStyle == "style_6"){
    $mailchimp_classes = "bg-blue-1";
    $button_classes = "bg-yellow-1 text-dark-1";
}
?>
<section class="layout-pt-md layout-pb-md mailchimp {{ $mailchimp_classes }} @if((!empty($row) && !empty($row->disable_subscribe_default) ) || !empty($disable_subscribe_default)) d-none @endif">
    <div class="container">
        <div class="row y-gap-30 justify-between items-center">
            <div class="col-auto">
                <div class="row y-gap-20  flex-wrap items-center">
                    <div class="col-auto">
                        <div class="icon-newsletter text-60 sm:text-40 text-white"></div>
                    </div>

                    <div class="col-auto">
                        <h4 class="text-26 text-white fw-600">{{ __('Your Travel Journey Starts Here') }}</h4>
                        <div class="text-white">{{ __("Sign up and we'll send the best deals to you") }}</div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form single-field -w-410 d-flex x-gap-10 y-gap-20">
                    @csrf
                    <div>
                        <input class="bg-white h-60 email-input" type="text" name="email" placeholder="{{__('Your Email')}}">
                    </div>
                    <div>
                        <button class="button -md h-60 {{ $button_classes }}">
                            {{__('Subscribe')}} <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        </button>
                    </div>
                    <div class="form-mess"></div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('Layout::parts.footer-style.index')
@include('Layout::parts.login-register-modal')
@include('Popup::frontend.popup')
@if(Auth::id())
    @include('Media::browser')
@endif
<!-- Custom script for all pages -->
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/libs/bs/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/vendors.js')}}"></script>
<script type="text/javascript" src="{{asset('themes/gotrip/js/main.js?_ver='.config('app.asset_version'))}}"></script>

{!! App\Helpers\MapEngine::scripts() !!}
<script src="{{ asset('libs/pusher.min.js') }}"></script>

@if(Auth::id())
    <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset('libs/carousel-2/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/moment.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
@if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable']))
    <div class="booking_cookie_agreement p-3 d-flex fixed-bottom">
        <div class="content-cookie">{!! clean(setting_item_with_lang('cookie_agreement_content')) !!}</div>
        <button class="btn save-cookie">{!! clean(setting_item_with_lang('cookie_agreement_button_text')) !!}</button>
    </div>
    <script>
        var save_cookie_url = '{{route('core.cookie.check')}}';
    </script>
    <script src="{{ asset('js/cookie.js?_ver='.config('app.asset_version')) }}"></script>
@endif

{{-- home.js --}}
<script src="{{ asset('themes/gotrip/dist/frontend/js/gotrip.js?_ver='.config('app.asset_version')) }}"></script>

@if(request('preview'))
    <script src="{{ asset('themes/gotrip/module/template/preview.js?_ver='.config('app.asset_version')) }}"></script>
@endif

@php \App\Helpers\ReCaptchaEngine::scripts() @endphp
@stack('js')

