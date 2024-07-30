<div class="sidebar py-20 px-20 rounded-4 bg-white bravo_filter">
    <form action="{{url(app_get_locale(false,false,'/').config('flight.flight_route_prefix'))}}" class="bravo_form_filter row y-gap-40">
            <div class="sidebar__item pb-30 -no-border">
                <h5 class="text-18 fw-500 mb-10">{{__('Price')}}</h5>
                <div class="row x-gap-10 y-gap-30">
                    <div class="col-12">
                        <div class="js-price-searchPage">
                            <div class="text-14 fw-500"></div>

                            <?php
                            $price_min = $pri_from = floor ( App\Currency::convertPrice($flight_min_max_price[0]) );
                            $price_max = $pri_to = ceil ( App\Currency::convertPrice($flight_min_max_price[1]) );
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
                            <div class="d-flex justify-between mb-20">
                                <div class="text-15 text-dark-1">
                                    <span class="js-lower"></span>
                                    -
                                    <span class="js-upper"></span>
                                </div>
                            </div>

                            <div class="px-5">
                                <div class="js-slider"></div>
                                <button type="submit" class="flex-center bg-blue-1 rounded-4 px-3 py-1 mt-3 text-12 fw-600 text-white btn-apply-price-range mt-20">{{__("APPLY")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @include('Layout::global.search.filters.attrs')

        <div class="bravo-clear-filter hidden-lg-up" style="display: none;">
            <a href="#" onclick="return false" class="button px-15 py-10 -dark-1 bg-blue-1 text-white">
                <i class="icon-loop-2 mr-10 text-12"></i>
                <span>{{__('Clear All')}}</span>
            </a>
        </div>
    </form>
</div>
