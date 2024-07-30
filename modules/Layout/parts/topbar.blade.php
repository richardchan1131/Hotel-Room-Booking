<div class="bravo_topbar">
    <div class="container">
        <div class="content">
            <div class="topbar-left">

                {!! clean(setting_item_with_lang("topbar_left_text")) !!}


            </div>
            <div class="topbar-right">
                <ul class="topbar-items">
                    @include('Core::frontend.currency-switcher')
                    @include('Language::frontend.switcher')
                @if(!Auth::check())
                        <li class="login-item">
                            <a href="#login" data-toggle="modal" data-target="#login" class="login">{{__('Login')}}</a>
                        </li>
                        @if(is_enable_registration())
                            <li class="signup-item">
                                <a href="#register" data-toggle="modal" data-target="#register" class="signup">{{__('Sign Up')}}</a>
                            </li>
                        @endif
                    @else
                        @include('Layout::parts.notification')
                        <li class="login-item dropdown">
                            <a href="#" data-toggle="dropdown" class="login">{{__("Hi, :name",['name'=>Auth::user()->getDisplayName()])}}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-user text-left">
                                @if(empty( setting_item('wallet_module_disable') ))
                                    <li class="credit_amount">
                                        <a href="{{route('user.wallet')}}"><i class="fa fa-money"></i> {{__("Credit: :amount",['amount'=>auth()->user()->balance])}}</a>
                                    </li>
                                @endif
                                @if(is_vendor())
                                <li class="menu-hr"><a href="{{route('vendor.dashboard')}}" class="menu-hr"><i class="icon ion-md-analytics"></i> {{__("Vendor Dashboard")}}</a></li>
                                @endif
                                <li class="@if(is_vendor()) menu-hr @endif">
                                    <a href="{{route('user.profile.index')}}"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                                </li>
                                @if(setting_item('inbox_enable'))
                                <li class="menu-hr">
                                    <a href="{{route('user.chat')}}"><i class="fa fa-comments"></i> {{__("Messages")}}
                                        @if($count = auth()->user()->unseen_message_count)
                                            <span class="badge badge-danger">{{$count}}</span>
                                        @endif
                                    </a>
                                </li>
                                @endif
                                    <li class="menu-hr"><a href="{{route('user.booking_history')}}"><i class="fa fa-clock-o"></i> {{__("Booking History")}}</a></li>
                                <li class="menu-hr"><a href="{{route('user.change_password')}}"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>

                                @if(is_enable_plan() )
                                    <li class="menu-hr"><a href="{{route('user.plan')}}"><i class="fa fa-list-alt"></i> {{__("My plan")}}</a></li>
                                @endif

                                    @if(isPro())
                                        <li class="menu-hr">
                                            <a href="{{route('support.index')}}">
                                                <i class="fa fa-list-alt"></i> {{__("Support Center")}}</a>
                                        </li>
                                    @endif

                                @if(is_admin())
                                    <li class="menu-hr"><a href="{{route('admin.index')}}"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                                @endif
                                <li class="menu-hr">
                                    <a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                                </li>
                            </ul>
                            <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
