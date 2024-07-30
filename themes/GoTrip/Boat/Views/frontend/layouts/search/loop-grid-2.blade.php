@php $translation = $row->translate(); @endphp

<a href="{{ $row->getDetailUrl() }}" class="cruiseCard -type-1 rounded-4 {{$wrap_class ?? ''}}">
    <div class="cruiseCard__image">
        <div class="cardImage ratio ratio-6:5">
            <div class="cardImage__content">
                @if($row->image_url)
                    @if(!empty($disable_lazyload))
                        <img  src="{{$row->image_url}}" class="img-responsive rounded-4 col-12 js-lazy" alt="{{ $translation->title }}">
                    @else
                        {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive rounded-4 col-12 js-lazy','alt'=>$translation->title]) !!}
                    @endif
                @endif
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
                    <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                        {{__("Featured")}}
                    </div>
                @endif
                @if($row->discount_percent)
                    <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white mt-5">
                        {{__("Sale off :number",['number'=>$row->discount_percent])}}
                    </div>
                @endif
            </div>

        </div>

    </div>

    <div class="cruiseCard__content mt-10">
        @if(!empty($row->location->name))
            @php $location = $row->location->translate() @endphp
            <div class="text-14 lh-14 text-light-1 mb-5">{{ $location->name ?? '' }}</div>
        @endif

        <h4 class="cruiseCard__title text-dark-1 text-18 lh-16 fw-500">
            <span>{{ $translation->title }}</span>
        </h4>

        <p class="text-light-1 lh-14 text-14 mt-5"></p>

        <div class="row y-gap-10 justify-between items-center mt-2">

            @if($row->max_guest)
                <div class="col-auto">
                    <div class="text-25 text-dark-1 fw-500 lh-1" title="{{ __("Max Guests") }}"><i class="icofont-ui-user-group input-icon field-icon"></i></div>
                    <div class="text-14 text-light-1">{{$row->max_guest}}</div>
                </div>
            @endif

            @if($row->cabin)
                <div class="col-auto">
                    <div class="text-25 text-dark-1 fw-500 lh-1" title="{{__("Cabin")}}"><i class="input-icon field-icon icofont-sail-boat-alt-2"></i></div>
                    <div class="text-14 text-light-1">{{$row->cabin}}</div>
                </div>
            @endif

            @if($row->length)
                <div class="col-auto">
                    <div class="text-25 text-dark-1 fw-500 lh-1" title="{{__("Length Boat")}}"><i class="input-icon field-icon icofont-yacht"></i></div>
                    <div class="text-14 text-light-1">{{$row->length}}</div>
                </div>
            @endif

            @if($row->speed)
                <div class="col-auto">
                    <div class="text-25 text-dark-1 fw-500 lh-1" title="{{__("Speed")}}"><i class="input-icon field-icon icofont-speed-meter"></i></div>
                    <div class="text-14 text-light-1">{{$row->speed}}</div>
                </div>
            @endif

        </div>

        <div class="row y-gap-20 justify-between items-center pt-5">
            <div class="col-auto">
                @if(setting_item('boat_enable_review'))
                    <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                    <div class="d-flex items-center">
                        <div class="icon-star text-yellow-1 text-10 mr-5"></div>

                        <div class="text-14 text-light-1">
                            <span class="text-15 text-dark-1 fw-500">{{ $reviewData['score_total'] }}</span>
                            @if($reviewData['total_review'] > 1)
                                {{ __(":number reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            <div class="col-auto">
                <div class="text-14 text-light-1">
                    {{ __('From') }}
                    <span class="text-16 fw-500 text-dark-1 d-inline-flex">{{ format_money($row->min_price) }}</span>
                </div>
            </div>
        </div>
    </div>
</a>
