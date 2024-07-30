<section class="header-banner gotrip-topbar py-5 bg-blue-1 z-2">
    <div class="container">
        <div class="row items-center justify-between">
            <div class="col-auto">
                @php
                $topbar_left_text = setting_item('topbar_left_text');
                @endphp
                @if(!empty($topbar_left_text))
                    {!! clean($topbar_left_text) !!}
                @endif
            </div>

            <div class="col-auto">
                <div class="row x-gap-15 items-center jusify-between">
                    <div class="col-auto">

                        <div class="row x-gap-20 items-center xxl:d-none">
                            <div class="col-auto">
                                <ul class="gotrip-dropdown">
                                    @include('Core::frontend.currency-switcher')
                                </ul>
                            </div>

                            <div class="col-auto">
                                <div class="w-1 h-20 bg-white-20"></div>
                            </div>

                            <div class="col-auto">
                                <ul class="gotrip-dropdown">
                                    @include('Language::frontend.switcher-dropdown')
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="col-auto xxl:d-none">
                        <div class="w-1 h-20 bg-white-20"></div>
                    </div>

                    <div class="col-auto md:d-none">
                        @if(!empty($page_vendor = get_page_url ( setting_item('vendor_page_become_an_expert'))))
                            <a href="{{ $page_vendor }}" class="text-12 text-white">{{ __("Become An Expert") }}</a>
                        @endif
                    </div>

                    <div class="col-auto md:d-none">
                        <div class="w-1 h-20 bg-white-20"></div>
                    </div>

                    <div class="col-auto">
                        @if(!Auth::check())
                            <a data-bs-toggle="modal" href="#login" class="text-12 text-white">{{ __("Sign In / Register") }}</a>
                        @else
                            <a href="{{ route('vendor.dashboard') }}" class="text-12 text-white">{{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
