@php
    $translation = $row->translate();
    $layout_style = $layout_style ?? '';
@endphp
<div class="border-top-light pt-30 loop-list-car {{$wrap_class ?? ''}}">
    <div class="row x-gap-20 y-gap-20">
        <div class="col-md-auto">
            <div class="relative d-flex">
                <div class="has-skeleton">
                    <div class="cardImage ratio ratio-5:4 w-250 md:w-1/1 rounded-4">
                        <div class="cardImage__content">
                            <a @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}">
                                @if($row->image_url)
                                    @if(!empty($disable_lazyload))
                                        <img  src="{{$row->image_url}}" class="rounded-4 col-12 js-lazy" alt="{{ $translation->title ?? 'image' }}">
                                    @else
                                        {!! get_image_tag($row->image_id,'medium',['class'=>'rounded-4 col-12 js-lazy','alt'=>$translation->title]) !!}
                                    @endif
                                @endif
                            </a>
                        </div>
                        <div class="service-wishlist {{$row->isWishList()}}" data-id="{{ $row->id }}" data-type="{{ $row->type }}">
                            <div class="cardImage__wishlist">
                                <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                    <i class="icon-heart text-12"></i>
                                </button>
                            </div>
                        </div>
                        <div class="cardImage__leftBadge">
                            @if($row->is_featured == "1")
                                <div class="py-5 px-15 rounded-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                                    {{__("Featured")}}
                                </div>
                            @endif
                            @if($row->discount_percent)
                                <div class="py-5 px-15 rounded-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white mt-5">
                                    {{__("Sale off :number",['number'=>$row->discount_percent])}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex flex-column h-full justify-between">
                <div class="">
                    <div class="row x-gap-5 items-center">
                        @if(!empty($row->location->name))
                            @php $location =  $row->location->translate() @endphp
                            <div class="col-auto">
                                <div class="text-14 text-light-1 has-skeleton">{{ $location->name }}</div>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-18 lh-16 fw-500 mt-5 has-skeleton">
                        <a @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}">{{ $translation->title }}</a>
                    </h3>
                </div>
                <div class="col-lg-12 mb-10">
                    <div class="row y-gap-5">
                        @if($row->passenger)
                            <div class="col-sm-6">
                                <div class="d-flex items-center has-skeleton">
                                    <i class="icon-user-2"></i>
                                    <div class="text-14 ml-10">{{__("Passenger")}}: {{$row->passenger}}</div>
                                </div>
                            </div>
                        @endif
                        @if($row->gear)
                            <div class="col-sm-6">
                                <div class="d-flex items-center has-skeleton">
                                    <i class="icon-transmission"></i>
                                    <div class="text-14 ml-10">{{__("Gear Shift")}}: {{$row->gear}}</div>
                                </div>
                            </div>
                        @endif
                        @if($row->baggage)
                            <div class="col-sm-6">
                                <div class="d-flex items-center has-skeleton">
                                    <i class="icon-luggage"></i>
                                    <div class="text-14 ml-10">{{__("Baggage")}}: {{$row->baggage}}</div>
                                </div>
                            </div>
                        @endif
                        @if($row->door)
                            <div class="col-sm-6">
                                <div class="d-flex items-center has-skeleton">
                                    <i class="icon-speedometer"></i>
                                    <div class="text-14 ml-10">{{__("Door")}}: {{$row->door}}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 mb-10">
                    <div class="d-flex flex-column h-full justify-between">
                        <div class="">
                            <h3 class="text-18 lh-16 fw-500"></h3>
                        </div>
                        @php $terms_ids = $row->terms->pluck('term_id');
                        $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
                        $terms = [];
                        @endphp
                        @if(!empty($attributes))
                            @foreach($attributes as $attr)
                                @php $terms = array_merge($terms,$attr['child']) @endphp
                            @endforeach
                        @endif
                        @if(!empty($terms))
                            <div class="row x-gap-10 y-gap-10">
                                @foreach($terms as $k => $term)
                                    @php if($k > 3) continue;
                            $translate_term = $term->translate()
                                    @endphp
                                    <div class="col-auto">
                                        <div class="border-light rounded-100 py-5 px-20 text-14 lh-14 has-skeleton">{{ $translate_term->name }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-auto text-right md:text-left">
            <div class="has-skeleton">
                @if(setting_item('car_enable_review'))
                        <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                    <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                        <div class="col-auto">
                            <div class="text-14 lh-14 fw-500">{{ $reviewData['review_text'] }}</div>
                            <div class="text-14 lh-14 text-light-1">@if($reviewData['total_review'] > 1)
                                    {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                                @else
                                    {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="flex-center text-dark-1 fw-600 text-14 size-40 rounded-4 bg-yellow-1">{{ $reviewData['score_total'] }}</div>
                        </div>
                    </div>
                @endif
                <div class="text-14 text-light-1 mt-10">{{ __("from") }}</div>
                <div class="d-flex justify-content-md-end align-baseline mt-5">
                    <div class="text-16 text-red-1 line-through mr-5">{{ $row->display_sale_price }}</div>
                    <div class="text-22 lh-12 fw-600">{{ $row->display_price }}</div>
                </div>
                <a href="{{ $row->getDetailUrl() }}" class="button h-50 px-24 bg-dark-1 -yellow-1 text-white mt-24">
                    {{ __('View Detail') }} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
        </div>
    </div>
</div>
