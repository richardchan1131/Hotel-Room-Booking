@php
    $translation = $row->translate();
@endphp
<div class="hotelsCard -type-1 item-loop {{$wrap_class ?? ''}}">
    <div class="hotelsCard__image">
        <div class="cardImage ratio ratio-1:1">
            <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}">
                <div class="cardImage__content">
                    @if($row->image_url)
                        @if(!empty($disable_lazyload))
                            <img  src="{{$row->image_url}}" class="img-responsive rounded-4 col-12 js-lazy" alt="">
                        @else
                            {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive rounded-4 col-12 js-lazy','alt'=>$translation->title]) !!}
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
    <div class="hotelsCard__content mt-10">
        <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">
            <a class="text-dark-1-i" href="{{ $row->getDetailUrl() }}"> <span>{{ $translation->title }}</span></a>
        </h4>
        @if(!empty($row->location->name))
            @php $location =  $row->location->translate() @endphp
            <p class="text-light-1 lh-14 text-14 mt-5">{{$location->name}}</p>
        @endif
        @if(setting_item('hotel_enable_review'))
            <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
            <div class="d-flex items-center mt-20">
                <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">{{ $reviewData['score_total'] }}</div>
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
            <div class="fw-500">
                {{ __('Starting from') }}
                <div class="d-inline-flex justify-content-md-end align-baseline">
                    <div class="text-16 text-red-1 line-through mr-5">{{ $row->display_sale_price }}</div>
                    <div class="text-22 lh-12 fw-600 text-blue-1">{{ $row->display_price }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
