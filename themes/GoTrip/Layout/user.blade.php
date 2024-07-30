<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$html_class ?? ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($favicon = setting_item('site_favicon'))
    <link rel="icon" type="image/png" href="{{!empty($favicon)?get_file_url($favicon,'full'):url('images/favicon.png')}}" />
    @include('Layout::parts.seo-meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/notification.css') }}" rel="newest stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/select2/css/select2.min.css") }}" >
    <link href="{{ asset('themes/gotrip/css/vendors.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/gotrip/css/main.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('dist/frontend/module/user/css/user.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/gotrip/dist/frontend/css/app.css?_v='.config('app.asset_version')) }}">
    <link rel="stylesheet" href="{{ asset('themes/gotrip/dist/frontend/css/user.css?_v='.config('app.asset_version')) }}">
    @include('Layout::parts.global-script')
    <script>
        var image_editer = {
            language: '{{ app()->getLocale() }}',
            translations: {
        {{ app()->getLocale() }}: {
            'header.image_editor_title': '{{ __('Image Editor') }}',
                'header.toggle_fullscreen': '{{ __('Toggle fullscreen') }}',
                'header.close': '{{ __('Close') }}',
                'header.close_modal': '{{ __('Close window') }}',
                'toolbar.download': '{{ __('Save Change') }}',
                'toolbar.save': '{{ __('Save') }}',
                'toolbar.apply': '{{ __('Apply') }}',
                'toolbar.saveAsNewImage': '{{ __('Save As New Image') }}',
                'toolbar.cancel': '{{ __('Cancel') }}',
                'toolbar.go_back': '{{ __('Go Back') }}',
                'toolbar.adjust': '{{ __('Adjust') }}',
                'toolbar.effects': '{{ __('Effects') }}',
                'toolbar.filters': '{{ __('Filters') }}',
                'toolbar.orientation': '{{ __('Orientation') }}',
                'toolbar.crop': '{{ __('Crop') }}',
                'toolbar.resize': '{{ __('Resize') }}',
                'toolbar.watermark': '{{ __('Watermark') }}',
                'toolbar.focus_point': '{{ __('Focus point') }}',
                'toolbar.shapes': '{{ __('Shapes') }}',
                'toolbar.image': '{{ __('Image') }}',
                'toolbar.text': '{{ __('Text') }}',
                'adjust.brightness': '{{ __('Brightness') }}',
                'adjust.contrast': '{{ __('Contrast') }}',
                'adjust.exposure': '{{ __('Exposure') }}',
                'adjust.saturation': '{{ __('Saturation') }}',
                'orientation.rotate_l': '{{ __('Rotate Left') }}',
                'orientation.rotate_r': '{{ __('Rotate Right') }}',
                'orientation.flip_h': '{{ __('Flip Horizontally') }}',
                'orientation.flip_v': '{{ __('Flip Vertically') }}',
                'pre_resize.title': '{{ __('Would you like to reduce resolution before editing the image?') }}',
                'pre_resize.keep_original_resolution': '{{ __('Keep original resolution') }}',
                'pre_resize.resize_n_continue': '{{ __('Resize & Continue') }}',
                'footer.reset': '{{ __('Reset') }}',
                'footer.undo': '{{ __('Undo') }}',
                'footer.redo': '{{ __('Redo') }}',
                'spinner.label': '{{ __('Processing...') }}',
                'warning.too_big_resolution': '{{ __('The resolution of the image is too big for the web. It can cause problems with Image Editor performance.') }}',
                'common.x': '{{ __('x') }}',
                'common.y': '{{ __('y') }}',
                'common.width': '{{ __('width') }}',
                'common.height': '{{ __('height') }}',
                'common.custom': '{{ __('custom') }}',
                'common.original': '{{ __('original') }}',
                'common.square': '{{ __('square') }}',
                'common.opacity': '{{ __('Opacity') }}',
                'common.apply_watermark': '{{ __('Apply watermark') }}',
                'common.url': '{{ __('URL') }}',
                'common.upload': '{{ __('Upload') }}',
                'common.gallery': '{{ __('Gallery') }}',
                'common.text': '{{ __('Text') }}',
        }
        }
        };
    </script>
    <!-- Styles -->
    @stack('css')
    <style type="text/css">
        .bravo_topbar, .bravo_header, .bravo_footer {
            display: none;
        }
        html, body, .bravo_wrap, .bravo_user_profile,
        .bravo_user_profile > .container-fluid > .row-eq-height > .col-md-3 {
            min-height: 100vh !important;
        }
    </style>
    {{--Custom Style--}}
    <link href="{{ route('core.style.customCss') }}" rel="stylesheet">
    @if(setting_item_with_lang('enable_rtl'))
        <link href="{{ asset('themes/gotrip/dist/frontend/css/rtl.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
    @if(setting_item_with_lang('enable_rtl'))
        <link href="{{ asset('dist/frontend/css/rtl.css') }}" rel="stylesheet">
    @endif
</head>
<body class="user-page {{$body_class ?? ''}} @if(setting_item_with_lang('enable_rtl')) is-rtl @endif">
@if(!is_demo_mode())
    {!! setting_item('body_scripts') !!}
@endif
<div class="bravo_wrap">
    <div class="header-margin"></div>
    @include('Layout::parts.user.header')

    <div class="dashboard bravo_user_profile p-0" data-x="dashboard" data-x-toggle="-is-sidebar-open">
        @include('User::frontend.layouts.sidebar')
        <div class="dashboard__main">
            <div class="dashboard__content bg-light-2">
                @yield('content')
                @include( 'Layout::parts.user.footer' )
            </div>
        </div>
        <div class="modal" tabindex="-1" id="modal_booking_detail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Booking ID: #')}} <span class="user_id"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">{{__("Loading...")}}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('libs/filerobot-image-editor/filerobot-image-editor.min.js?_ver='.config('app.asset_version')) }}"></script>
@if(!is_demo_mode())
    {!! setting_item('footer_scripts') !!}
@endif
</body>
</html>
