@php
    $translation = $row->translate();
@endphp
<div class="carCard -type-1 d-block rounded-4 item-loop-gird-2 {{$wrap_class ?? ''}}">
    <div class="carCard__image">
        <div class="has-skeleton">
        <div class="cardImage ratio border-light ratio-6:5">
            <a @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}">
                <div class="cardImage__content">
                    @if($row->image_url)
                        @if(!empty($disable_lazyload))
                            <img  src="{{$row->image_url}}" class="rounded-4 col-12 js-lazy" alt="{{ $translation->title ?? 'image' }}">
                        @else
                            {!! get_image_tag($row->image_id,'medium',['class'=>'rounded-4 col-12 js-lazy','alt'=>$translation->title]) !!}
                        @endif
                    @endif
                </div>
            </a>
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
    </div>
    <div class="carCard__content mt-10">
        <div class="d-flex items-center lh-14 mb-5">
            @if(!empty($row->location->name))
                @php $location =  $row->location->translate() @endphp
                <div class="text-14 text-light-1 has-skeleton">{{ $location->name }}</div>
            @endif
        </div>
        <h4 class="text-dark-1 text-18 lh-16 fw-500 has-skeleton">
            <a class="text-dark-1-i" @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}"> <span>{{ $translation->title }}</span></a>
        </h4>
        <p class="text-light-1 lh-14 text-14 mt-5"></p>
        <div class="row x-gap-20 y-gap-10 items-center pt-5">
            <div class="col-auto">
                <div class="d-flex items-center text-14 text-dark-1 has-skeleton">
                    <i class="icon-user-2 mr-10"></i>
                    <div class="lh-14">{{$row->passenger}}</div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex items-center text-14 text-dark-1 has-skeleton">
                    <i class="icon-luggage mr-10"></i>
                    <div class="lh-14">{{$row->baggage}}</div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex items-center text-14 text-dark-1 has-skeleton">
                    <i class="icon-transmission mr-10"></i>
                    <div class="lh-14">{{$row->gear}}</div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex items-center text-14 text-dark-1 has-skeleton">
                    <i class="icon-speedometer mr-10"></i>
                    <div class="lh-14">{{__("Door")}}: {{$row->door}}</div>
                </div>
            </div>
        </div>
        @if(setting_item('car_enable_review'))
            @php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total']; @endphp
            <div class="d-flex items-center mt-20 has-skeleton">
                <div class="flex-center bg-yellow-1 rounded-4 size-30 text-12 fw-600 text-dark-1">{{ $reviewData['score_total'] }}</div>
                <div class="text-14 text-dark-1 fw-500 ml-10">{{ $reviewData['review_text'] }}</div>
                <div class="text-14 text-light-1 ml-10">
                    @if($reviewData['total_review'] > 1)
                        {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                    @else
                        {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                    @endif
                </div>
            </div>
        @endif
        <div class="mt-5">
            <div class="text-light-1 has-skeleton">
                {{ __('from') }}
                <span class="text-14  text-red-1 line-through d-inline-flex">{{ $row->display_sale_price }}</span>
                <span class="fw-500 text-dark-1 d-inline-flex">{{ $row->display_price }}</span>
            </div>
        </div>
    </div>
</div>
