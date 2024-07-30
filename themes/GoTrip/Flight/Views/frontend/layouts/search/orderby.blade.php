
<div class="item d-flex align-items-center">
    @php
        $param = request()->input();
        $orderby =  request()->input("orderby");
    @endphp
    <div class="item-title mr-10">
        {{ __("Sort by:") }}
    </div>
    <div class="button -blue-1 h-40 px-30 rounded-100 bg-blue-1-05 text-15 text-blue-1 dropdown">
                            <span class=" dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @switch($orderby)
                                    @case("price_low_high")
                                        {{ __("Price (Low to high)") }}
                                        @break
                                    @case("price_high_low")
                                        {{ __("Price (High to low)") }}
                                        @break
                                    @default
                                        {{ __("Recommended") }}
                                @endswitch
                            </span>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            @php $param['orderby'] = "" @endphp
            <a class="dropdown-item" href="{{ route("flight.search",$param) }}">{{ __("Recommended") }}</a>
            @php $param['orderby'] = "price_low_high" @endphp
            <a class="dropdown-item" href="{{ route("flight.search",$param) }}">{{ __("Price (Low to high)") }}</a>
            @php $param['orderby'] = "price_high_low" @endphp
            <a class="dropdown-item" href="{{ route("flight.search",$param) }}">{{ __("Price (High to low)") }}</a>
        </div>
    </div>
</div>
