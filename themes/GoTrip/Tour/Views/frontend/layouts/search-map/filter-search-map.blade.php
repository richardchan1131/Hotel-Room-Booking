<div class="row x-gap-10 y-gap-10 pt-20 pb-20">
    <div class="col-auto">
        <div class="relative js-form-dd">
            <button class="d-flex items-center px-15 py-5 lh-16 text-14 rounded-100 border-light -dd-button" data-x-dd-click="dropdownRating">
                {{ __('Price') }}
                <i class="icon icon-chevron-sm-down text-7 ml-15"></i>
            </button>
            <div class="dropRating" data-x-dd="dropdownRating" data-x-dd-toggle="-is-active">
                <div class="px-20 py-20 rounded-4 bg-white border-light">
                    <h5 class="text-18 fw-500 mb-10">{{ __('Price') }}</h5>
                    <div class="row x-gap-10 y-gap-10 pt-10">

                        <div class="js-price-searchPage">
                            <div class="text-14 fw-500"></div>

                            <?php
                            $price_min = $pri_from = floor ( App\Currency::convertPrice($tour_min_max_price[0]) );
                            $price_max = $pri_to = ceil ( App\Currency::convertPrice($tour_min_max_price[1]) );
                            if (!empty($price_range = Request::query('price_range'))){
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
                            </div>
                        </div>

                        <button type="submit" class="flex-center bg-blue-1 rounded-4 px-3 py-1 mt-3 text-12 fw-600 text-white btn-apply-price-range">{{__("APPLY")}}</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-auto">
        <div class="relative js-form-dd">
            <button class="d-flex items-center px-15 py-5 lh-16 text-14 rounded-100 border-light -dd-button" data-x-dd-click="dropdownRating">
                {{ __('Review Score') }}
                <i class="icon icon-chevron-sm-down text-7 ml-15"></i>
            </button>
            <div class="dropRating" data-x-dd="dropdownRating" data-x-dd-toggle="-is-active">
                <div class="px-20 py-20 rounded-4 bg-white border-light">
                    <h5 class="text-18 fw-500 mb-10">{{ __('Review Score') }}</h5>
                    <div class="bravo-review-score">
                        <div class="row x-gap-10 y-gap-10 pt-10">
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-value="1" class="button -blue-1 bg-blue-1-05 text-blue-1 py-10 px-20 rounded-100">1</a>
                                <input type="hidden" class="review_score" name="review_score[]" value="">
                            </div>

                            <div class="col-auto">
                                <a href="javascript:void(0)" data-value="2" class="button -blue-1 bg-blue-1-05 text-blue-1 py-10 px-20 rounded-100">2</a>
                                <input type="hidden" class="review_score" name="review_score[]" value="">
                            </div>

                            <div class="col-auto">
                                <a href="javascript:void(0)" data-value="3" class="button -blue-1 bg-blue-1-05 text-blue-1 py-10 px-20 rounded-100">3</a>
                                <input type="hidden" class="review_score" name="review_score[]" value="">
                            </div>

                            <div class="col-auto">
                                <a href="javascript:void(0)" data-value="4" class="button -blue-1 bg-blue-1-05 text-blue-1 py-10 px-20 rounded-100">4</a>
                                <input type="hidden" class="review_score" name="review_score[]" value="">
                            </div>

                            <div class="col-auto">
                                <a href="javascript:void(0)" data-value="5" class="button -blue-1 bg-blue-1-05 text-blue-1 py-10 px-20 rounded-100">5</a>
                                <input type="hidden" class="review_score" name="review_score[]" value="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Layout::global.search.filters-map.attrs')

</div>


