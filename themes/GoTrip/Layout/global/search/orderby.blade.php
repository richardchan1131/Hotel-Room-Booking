<div class="row x-gap-20 y-gap-20">
    <div class="col-auto">
        <div class="item d-flex align-items-center">
            @php
                $param = request()->input();
                $orderby =  request()->input("orderby");
            @endphp
            <div class="mr-5">
                {{ __("Sort by:") }}
            </div>
            <input type="hidden" name="orderby" value="{{$orderby}}">
            <div class="dropdown orderby">
                <span class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-up-down text-14 mr-10"></i>
                    <span class="dropdown-toggle">
                        @switch($orderby)
                            @case("price_low_high")
                                {{ __("Price (Low to high)") }}
                                @break
                            @case("price_high_low")
                                {{ __("Price (High to low)") }}
                                @break
                            @case("rate_high_low")
                                {{ __("Rating (High to low)") }}
                                @break
                            @default
                                {{ __("Recommended") }}
                        @endswitch
                        </span>
                </span>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-value="">{{ __("Recommended") }}</a>
                    <a class="dropdown-item" href="#" data-value="price_low_high">{{ __("Price (Low to high)") }}</a>
                    <a class="dropdown-item" href="#" data-value="price_high_low">{{ __("Price (High to low)") }}</a>
                    <a class="dropdown-item" href="#" data-value="rate_high_low">{{ __("Rating (High to low)") }}</a>
                </div>
            </div>
        </div>
    </div>
    @if(empty($hidden_map_button))
        <div class="col-auto">
            <button class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1" onclick="window.location.href='{{ route($routeName,['_layout'=>'map']) }}'">
                {{__("Show on the map")}}
            </button>
        </div>
        <div class="col-auto d-none lg:d-block">
            <button data-x-click="filterPopup" class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                <i class="icon-up-down text-14 mr-10"></i>
                {{__('Filter')}}
            </button>
        </div>
    @endif
</div>
