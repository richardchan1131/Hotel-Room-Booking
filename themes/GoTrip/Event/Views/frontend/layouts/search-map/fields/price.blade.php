<div class="col-auto">

    <div class="dropdown js-dropdown js-price-active">
        <div class="dropdown__button d-flex items-center text-14 rounded-100 border-light px-15 h-34" data-el-toggle=".js-price-toggle" data-el-toggle-active=".js-price-active">
            <span class="js-dropdown-title">{{__('Price Filter')}}</span>
            <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
        </div>

        <div class="toggle-element -dropdown js-click-dropdown js-price-toggle">
            <div class="bravo-filter-price">
                <?php
                $price_min = $pri_from = floor ( App\Currency::convertPrice($event_min_max_price[0]) );
                $price_max = $pri_to = ceil ( App\Currency::convertPrice($event_min_max_price[1]) );
                if (!empty($price_range = Request::query('price_range'))) {
                    $pri_from = explode(";", $price_range)[0];
                    $pri_to = explode(";", $price_range)[1];
                }
                $currency = App\Currency::getCurrency( App\Currency::getCurrent() );
                ?>
                <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                       data-symbol=" {{$currency['symbol'] ?? ''}}"
                       data-min="{{$price_min}}"
                       data-max="{{$price_max}}"
                       data-from="{{$pri_from}}"
                       data-to="{{$pri_to}}"
                       readonly="" value="{{$price_range}}">
                <div class="text-right">
                    <br>
                    <a href="#" onclick="return false;" class="btn btn-primary btn-sm btn-apply-advances">{{__("APPLY")}}</a>

                </div>
            </div>
        </div>
    </div>

</div>
