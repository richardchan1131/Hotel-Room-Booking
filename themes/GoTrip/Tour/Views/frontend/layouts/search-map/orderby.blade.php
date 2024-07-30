<div class="item d-flex align-items-center">
    @php
        $param = request()->input();
        $orderby =  request()->input("orderby");
    @endphp
    <div class="mr-5">
        {{ __("Sort by:") }}
    </div>
    <div class="dropdown">
        <span class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-up-down text-14 mr-10"></i>
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
        <div class="dropdown-menu dropdown-menu-right bravo-order" aria-labelledby="dropdownMenuButton">
            @php $param['orderby'] = "" @endphp
            <a class="dropdown-item" data-order="{{$param['orderby']}}" href="javascript:void(0)">{{ __("Recommended") }}</a>
            @php $param['orderby'] = "price_low_high" @endphp
            <a class="dropdown-item" data-order="{{$param['orderby']}}" href="javascript:void(0)">{{ __("Price (Low to high)") }}</a>
            @php $param['orderby'] = "price_high_low" @endphp
            <a class="dropdown-item" data-order="{{$param['orderby']}}" href="javascript:void(0)">{{ __("Price (High to low)") }}</a>
            @php $param['orderby'] = "rate_high_low" @endphp
            <a class="dropdown-item" data-order="{{$param['orderby']}}" href="javascript:void(0)">{{ __("Rating (High to low)") }}</a>
            <input type="hidden" class="orderby" name="orderby" value="">
        </div>
    </div>
</div>
