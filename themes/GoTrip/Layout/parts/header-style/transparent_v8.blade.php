@include("Layout::parts.topbar")
<header data-add-bg="bg-dark-1" class="header mt-40 js-header {{$headerStyle}}" data-x="header" data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="header__container container gotrip-header-{{$headerStyle}} ">
        <div class="row justify-between items-center">
            @php
                $logo = setting_item('logo_id');
                $logoDark = setting_item('logo_id_dark');
            @endphp
            <div class="col-auto">
                <div class="d-flex items-center">
                    <a href="{{ url(app_get_locale(false,'/')) }}" class="header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
                        @if($logo)
                            <img class="logo-light" src="{{get_file_url($logo,'full')}}" alt="{{setting_item("site_title")}}">
                        @endif
                        @if($logoDark)
                            <img class="logo-dark" src="{{get_file_url($logoDark,'full')}}" alt="{{setting_item("site_title")}}">
                        @endif
                    </a>
                </div>
            </div>

            <div class="col-auto">
                <div class="d-flex items-center">

                    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                        <div class="mobile-overlay"></div>

                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>

                            <div class="menu js-navList">
                                @php $textColor = 'text-white';
                                    generate_menu('primary',[
                                        'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                                        'custom_class' => $textColor,
                                        'desktop_menu' => true,
                                        'enable_mega_menu' => true
                                    ])
                                @endphp
                            </div>

                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                            </div>
                        </div>
                    </div>

                    <div class="d-none xl:d-flex x-gap-20 items-center pl-20 text-white" data-x="header-mobile-icons" data-x-toggle="text-white">
                        <div>
                            @if(!Auth::check())
                                <a href="{{ route('vendor.dashboard') }}" class="d-flex items-center icon-user text-inherit text-22"></a>
                            @else
                                <a data-bs-toggle="modal" href="#login" class="d-flex items-center icon-user text-inherit text-22"></a>
                            @endif
                        </div>
                        <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
