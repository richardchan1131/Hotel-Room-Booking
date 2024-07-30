@php
    $headerStyle = (!empty($row->header_style)) ? $row->header_style : 'normal' ;
    $dataBg = 'bg-dark-1';
    $navTextStyle =  'text-white';
    switch ($headerStyle){
        case 'transparent': $headerClass = 'bg-green is-sticky'; break;
        case 'transparent_v2': $headerClass = 'header_2'; break;
        case 'transparent_v3': $headerClass = '-type-2'; break;
        case 'transparent_v4':{
            $headerClass = '-type-5 transparent_v4';
            $dataBg = '-header-5-sticky';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v5':{
            $headerClass = '';
            $dataBg = 'bg-white';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v6':
        case 'transparent_v9':{
            $headerClass = '';
            $dataBg = 'bg-white';
            $container_class = 'header__container header__container-1500 mx-auto';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v7':{
            $headerClass = '';
            $dataBg = 'bg-dark-1';
            $container_class = 'header__container';
            break;
        }
        case 'normal_white':{
            $headerClass = '';
            $navTextStyle = 'text-dark-1';
            $dataBg = 'bg-white';
            break;
        }
        default: $headerClass = '-fixed bg-dark-3';
    }
@endphp
@switch($headerStyle)
    @case("transparent_v8")
        @include("Layout::parts.header-style.transparent_v8")
        @break
    @default
        <header data-add-bg="{{ $dataBg }}" class="header {{ $headerClass }} js-header bravo_header" data-x="header" data-x-toggle="is-menu-opened">
            <div data-anim="fade" class="{{ $container_class ?? 'header__container' }} px-30 sm:px-20 @if($headerStyle == 'transparent_v2') container @endif is-in-view">
                <div class="row justify-between items-center">
                    <div class="col-auto @if($headerStyle == 'transparent_v7') col-left @endif">
                        @php
                            $logo = setting_item('logo_id');
                            $logoDark = setting_item('logo_id_dark');
                            if($headerStyle == 'transparent_v9') $logo = $logoDark ;
                        @endphp
                        @if($headerStyle == 'transparent_v2')
                            @include("Layout::parts.header-style.$headerStyle")
                            <div class="d-none xl:d-block">
                                @include("Layout::parts.header-style.normal")
                            </div>
                        @elseif($headerStyle == 'transparent_v4')
                            @include("Layout::parts.header-style.transparent_v2",['textColor' => 'text-dark-1'])
                        @elseif($headerStyle == 'normal_white')
                            @include("Layout::parts.header-style.normal",['textColor' => 'text-dark-1'])
                        @else
                            @include("Layout::parts.header-style.normal")
                        @endif
                    </div>
            @if($headerStyle == 'transparent_v3')
                <div class="col-auto xl:d-none">
                    <a href="{{url(app_get_locale(false,'/'))}}" class="header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
                        @if($logo)
                            <img class="logo-light" src="{{get_file_url($logo,'full')}}" alt="{{setting_item("site_title")}}">
                        @endif
                        @if($logoDark)
                            <img class="logo-dark" src="{{get_file_url($logoDark,'full')}}" alt="{{setting_item("site_title")}}">
                        @endif
                    </a>
                </div>
            @endif
            <div class="col-auto">
                <div class="d-flex items-center">
                    <div class="header-menu menu-right">
                        <div class="mobile-overlay"></div>
                        <div class="header-menu__content">
                            <div class="menu js-navList">
                                <ul class="menu__nav {{$navTextStyle}} -is-active">
                                    @include('Core::frontend.currency-switcher')
                                    @include('Language::frontend.switcher-dropdown')
                                    @if(!Auth::check())
                                        <div class="d-flex items-center ml-20 is-menu-opened-hide md:d-none">
                                            @php $btn_expert = '-white bg-white text-dark-1';
                                                $btn_login = 'border-white -outline-white text-white';
                                                if ($headerStyle == 'transparent_v6'){
                                                    $btn_expert = '-blue-1 bg-dark-1 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'normal_white'){
                                                    $btn_expert = '-white bg-blue-1 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'transparent_v9'){
                                                    $btn_expert = '-blue-1 bg-dark-4 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'transparent_v5'){
                                                    $btn_expert = '-blue-1 bg-dark-4 text-white';
                                                    $btn_login = 'border-dark-4 -blue-1 h-50 text-dark-4';
                                                }
                                            @endphp

                                                    @if(!empty($page_vendor = get_page_url ( setting_item('vendor_page_become_an_expert'))))
                                                        <a href="{{ $page_vendor }}" class="{{$btn_expert}} button px-30 fw-400 text-14  h-50">{{ __('Become An Expert') }}</a>
                                                    @endif
                                                    <a data-bs-toggle="modal" href="#login" class="{{$btn_login}} button px-30 fw-400 text-14  h-50 ml-20">{{ __('Sign In / Register') }}</a>
                                                </div>
                                            @else
                                                <li class="login-item menu-item-has-children">
                                                    <a href="#" class="is_login">
                                                    <span class="mr-10">
                                                        @if($avatar_url = Auth::user()->getAvatarUrl())
                                                            <img class="avatar rounded-circle" src="{{$avatar_url}}" alt="{{ Auth::user()->getDisplayName()}}" width="30" height="30">
                                                        @else
                                                            <span class="avatar-text rounded-circle">{{ucfirst( Auth::user()->getDisplayName()[0])}}</span>
                                                        @endif
                                                        {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                                                    </span>
                                                        <i class="icon icon-chevron-sm-down"></i>
                                                    </a>
                                                    <ul class="subnav">
                                                        @if(Auth::user()->hasPermission('dashboard_vendor_access'))
                                                            <li><a href="{{route('vendor.dashboard')}}" class="dropdown-item"><i class="fa fa-line-chart mr-10"></i> {{__("Vendor Dashboard")}}</a></li>
                                                        @endif
                                                        <li class="@if(Auth::user()->hasPermission('dashboard_vendor_access')) menu-hr @endif">
                                                            <a href="{{route('user.profile.index')}}" class="dropdown-item"><i class="fa fa-address-card mr-10"></i> {{__("My profile")}}</a>
                                                        </li>
                                                        @if(setting_item('inbox_enable'))
                                                            <li class="menu-hr"><a href="{{route('user.chat')}}" class="dropdown-item"><i class="fa fa-comments mr-10"></i> {{__("Messages")}}</a></li>
                                                        @endif
                                                        <li class="menu-hr"><a href="{{route('user.booking_history')}}" class="dropdown-item"><i class="fa fa-clock-o mr-10"></i> {{__("Booking History")}}</a></li>
                                                        <li class="menu-hr"><a href="{{route('user.change_password')}}" class="dropdown-item"><i class="fa fa-lock mr-10"></i> {{__("Change password")}}</a></li>
                                                        @if(Auth::user()->hasPermission('dashboard_access'))
                                                            <li class="menu-hr"><a href="{{route('admin.index')}}" class="dropdown-item"><i class="fa fa-dashboard mr-10"></i> {{__("Admin Dashboard")}}</a></li>
                                                        @endif
                                                        <li class="menu-hr">
                                                            <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out mr-10"></i> {{__('Logout')}}</a>
                                                        </li>
                                                    </ul>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            @endif
                                            <div class="d-none xl:d-flex x-gap-20 items-center pl-30 text-white" data-x="header-mobile-icons" data-x-toggle="text-white">
                                                <div>
                                                    @if(!Auth::check())
                                                        <a href="{{ url('/login') }}" class="d-flex items-center icon-user text-inherit text-22"></a>
                                                    @else
                                                        <div class="login-mobile-item dropdown ml-20">
                                                            <a href="#" data-bs-toggle="dropdown" class="icon-user text-inherit text-22 is_login"></a>
                                                            <ul class="dropdown-menu text-left">
                                                                <li>
                                                                    <a href="#" class="dropdown-item">
                                                                        @if($avatar_url = Auth::user()->getAvatarUrl())
                                                                            <img class="avatar" src="{{$avatar_url}}" alt="{{ Auth::user()->getDisplayName()}}" width="30" height="30">
                                                                        @else
                                                                            <span class="avatar-text">{{ucfirst( Auth::user()->getDisplayName()[0])}}</span>
                                                                        @endif
                                                                        {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                                                                    </a>
                                                                </li>
                                                                @if(Auth::user()->hasPermission('dashboard_vendor_access'))
                                                                    <li><a href="{{route('vendor.dashboard')}}" class="dropdown-item"><i class="icon ion-md-analytics"></i> {{__("Vendor Dashboard")}}</a></li>
                                                                @endif
                                                                <li class="@if(Auth::user()->hasPermission('dashboard_vendor_access')) menu-hr @endif">
                                                                    <a href="{{route('user.profile.index')}}" class="dropdown-item"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                                                                </li>
                                                                @if(setting_item('inbox_enable'))
                                                                    <li class="menu-hr"><a href="{{route('user.chat')}}" class="dropdown-item"><i class="fa fa-comments"></i> {{__("Messages")}}</a></li>
                                                                @endif
                                                                <li class="menu-hr"><a href="{{route('user.booking_history')}}" class="dropdown-item"><i class="fa fa-clock-o"></i> {{__("Booking History")}}</a></li>
                                                                <li class="menu-hr"><a href="{{route('user.change_password')}}" class="dropdown-item"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>
                                                                @if(Auth::user()->hasPermission('dashboard_access'))
                                                                    <li class="menu-hr"><a href="{{route('admin.index')}}" class="dropdown-item"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                                                                @endif
                                                                <li class="menu-hr">
                                                                    <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                                                                </li>
                                                            </ul>
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                {{ csrf_field() }}
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none xl:d-flex x-gap-20 items-center pl-30 {{$navTextStyle}}" data-x="header-mobile-icons" data-x-toggle="text-white">
                            <div><a href="@if(!Auth::check()) {{ url('/login') }} @else {{ route('user.profile.index') }} @endif" class="d-flex items-center icon-user text-inherit text-22"></a></div>
                            @if($headerStyle !== 'transparent_v4')
                                <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-none xl:d-flex x-gap-20 items-center pl-30" data-x="header-mobile-icons" data-x-toggle="text-white">
                </div>
            </div>
        </header>
    @break
@endswitch
