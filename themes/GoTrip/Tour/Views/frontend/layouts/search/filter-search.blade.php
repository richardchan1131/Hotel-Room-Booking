@if($layout == 'grid')
    <div class="sidebar__item -no-border mb-30 lg:d-none">
        <div class="px-20 py-20 bg-light-2 rounded-4">
            <h5 class="text-18 fw-500 mb-10">{{setting_item_with_lang("tour_page_search_title")}}</h5>
            @include('Tour::frontend.layouts.search.form-search', ['style' => 'sidebar'])
        </div>
    </div>
@endif

<form action="{{url(app_get_locale(false,false,'/').config('tour.tour_route_prefix'))}}" method="get" class="bravo_form_filter bravo_filter lg:d-none" data-x="filterPopup" data-x-toggle="-is-active" >
     <aside class="sidebar y-gap-40 p-4 p-lg-0">
        <div data-x-click="filterPopup" class="-icon-close is_mobile pb-0">
            <i class="icon-close"></i>
        </div>
        <div class="sidebar__item -no-border">
            <h5 class="text-18 fw-500 mb-10">{{__("Tour Type")}}</h5>
            <div class="sidebar-checkbox">
                <?php
                $current_category_ids = Request::query('cat_id');
                $traverse = function ($categories, $prefix = '') use (&$traverse, $current_category_ids) {
                $i = 0;
                foreach ($categories as $category) {
                $checked = '';
                if (!empty($current_category_ids)) {
                    foreach ($current_category_ids as $key => $current) {
                        if ($current == $category->id)
                            $checked = 'checked';
                    }
                }
                $translate = $category->translate()
                ?>
                    <div class="row y-gap-10 items-center justify-between">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="form-checkbox ">
                                    <input name="cat_id[]" {{$checked}} type="checkbox" value="{{$category->id}}">
                                    <div class="form-checkbox__mark">
                                        <div class="form-checkbox__icon icon-check"></div>
                                    </div>
                                </div>
                                <div class="text-15 ml-10">{{$prefix}} {{$translate->name}}</div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="text-15 text-light-1"></div>
                        </div>
                    </div>
                <?php
                $i++;
                $traverse($category->children, $prefix . '-');
                }
                };
                $traverse($tour_category);
                ?>
            </div>
        </div>
        <div class="sidebar__item pb-30">
            <h5 class="text-18 fw-500 mb-10">{{__('Price')}}</h5>
            <div class="row x-gap-10 y-gap-30">
                <div class="col-12">
                    <div class="js-price-searchPage">
                        <div class="text-14 fw-500"></div>

                        <?php
                        $price_min = $pri_from = floor ( App\Currency::convertPrice($tour_min_max_price[0]) );
                        $price_max = $pri_to = ceil ( App\Currency::convertPrice($tour_min_max_price[1]) );
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
                        </div>
                        <button type="submit" class="flex-center bg-blue-1 rounded-4 px-3 py-1 mt-3 text-12 fw-600 text-white btn-apply-price-range mt-20">{{__("APPLY")}}</button>
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
    </aside>
</form>
