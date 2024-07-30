@php $textColor = $textColor ?? 'text-white' @endphp
<div class="d-flex items-center @if($headerStyle != 'transparent_v4') xl:d-none @endif gotrip-header-{{$headerStyle}}">
    <div class="mr-20">
        <button class="d-flex items-center icon-menu {{$textColor}} text-20" data-x-click="desktopMenu"></button>
    </div>
    <a href="{{url(app_get_locale(false,'/'))}}" class="header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
        @if($logo)
            <img class="logo-light" src="{{get_file_url($logo,'full')}}" alt="{{setting_item("site_title")}}">
        @endif
        @if($logoDark)
            <img class="logo-dark" src="{{get_file_url($logoDark,'full')}}" alt="{{setting_item("site_title")}}">
        @endif
    </a>
     @if($headerStyle == 'transparent_v4')
        <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
            <div class="mobile-overlay"></div>
            <div class="header-menu__content">
                <div class="mobile-bg js-mobile-bg"></div>
                <div class="menu js-navList">
                    @php generate_menu('primary',[
                        'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                        'custom_class' => 'text-dark-1',
                        'desktop_menu' => true,
                        "enable_mega_menu" => true
                     ])
                    @endphp
                </div>
            </div>
        </div>
    @endif
    <div class="desktopMenu js-desktopMenu" data-x="desktopMenu" data-x-toggle="is-menu-active">
        <div class="desktopMenu-overlay"></div>
        <div class="desktopMenu__content">
            <div class="mobile-bg js-mobile-bg"></div>
            <div class="px-30 py-20 sm:px-20 sm:py-10 border-bottom-light">
                <div class="row justify-between items-center">
                    <div class="col-auto">
                        <div class="text-20 fw-500">{{__('Main Menu')}}</div>
                    </div>

                    <div class="col-auto">
                        <button class="icon-close text-15" data-x-click="desktopMenu"></button>
                    </div>
                </div>
            </div>
            <div class="h-full px-30 py-30 sm:px-0 sm:py-10">
                <div class="menu js-navList">
                    @php generate_menu('primary',[
                                            'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                                            'custom_class' => ($row->header_style ?? '' == 'transparent') ? 'text-white' : 'text-dark-1',
                                            'desktop_menu' => true
                                         ])
                    @endphp
                </div>
            </div>
        </div>
    </div>
</div>
