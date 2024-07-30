@php
    if($headerStyle == "normal_white"){
        $logo = $logoDark;
    }
@endphp
<div class="d-flex items-center gotrip-header-{{$headerStyle}}">
    <a href="{{url(app_get_locale(false,'/'))}}" class="@if($headerStyle == 'transparent_v3') d-none xl:d-flex @endif header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
        @if($logo)
            <img class="logo-light" src="{{get_file_url($logo,'full')}}" alt="{{setting_item("site_title")}}">
        @endif
        @if($logoDark)
            <img class="logo-dark" src="{{get_file_url($logoDark,'full')}}" alt="{{setting_item("site_title")}}">
        @endif
    </a>
    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
        <div class="mobile-overlay"></div>
        <div class="header-menu__content">
            <div class="mobile-bg js-mobile-bg"></div>
            <div class="menu js-navList">
                @php $textColor = $textColor ?? 'text-white';
                    if ($headerStyle == 'transparent_v5' || $headerStyle == 'transparent_v6' || $headerStyle == 'transparent_v9') $textColor = 'text-dark-1';
                    generate_menu('primary',[
                        'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                        'custom_class' => $textColor,
                        'desktop_menu' => true,
                        'enable_mega_menu' => true
                     ])
                @endphp
            </div>
            <div class="mobile-footer px-20 py-10 border-top-light js-mobile-footer">
                @include('Core::frontend.currency-switcher')
                @include('Language::frontend.switcher-dropdown')
            </div>
        </div>
    </div>
</div>
