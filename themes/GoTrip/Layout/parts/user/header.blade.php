<header data-add-bg="" class="header -dashboard bg-white js-header" data-x="header" data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="header__container px-30 sm:px-20 is-in-view">
        <div class="-left-side">
            <a href="{{url(app_get_locale(false,'/'))}}" class="header-logo" data-x="header-logo" data-x-toggle="is-logo-dark">
                @php
                    $logo_id = setting_item("logo_id_dark");
                @endphp
                @if($logo_id)
                    <?php $logo = get_file_url($logo_id,'full') ?>
                    <img src="{{ $logo }}" alt="{{setting_item("site_title")}}">
                    <img src="{{ $logo }}" alt="{{setting_item("site_title")}}">
                @endif
            </a>
        </div>
        <div class="row justify-between items-center pl-60 lg:pl-20">
            <div class="col-auto">
                <div class="d-flex items-center lh-1">
                    <button data-x-click="dashboard">
                        <i class="icon-menu-2 text-20"></i>
                        <span class="fw-500 md:d-none">{{ __("MENU") }}</span>
                    </button>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex items-center">
                    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                        <div class="mobile-overlay"></div>
                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>
                            <div class="menu js-navList">
                                @php generate_menu('primary',[
                                    'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                                    'custom_class' => 'text-dark-1 fw-500',
                                    'desktop_menu' => true
                                 ])
                                @endphp
                            </div>
                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                            </div>
                        </div>
                    </div>
                    <div class="row items-center x-gap-5 y-gap-20 pl-20">
                        <div class="col-auto">
                            <div class="relative">
                                @include("Layout::parts.user.notification")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
