@php
    $translation = $row->translate();
    $layout_style = $layout_style ?? '';
@endphp

<div class="item-loop {{$wrap_class ?? ''}}">
    <div class="activityCard -type-1 ">
        <div class="activityCard__image has-skeleton">
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
        <div class="activityCard__content mt-10">
            <div class="d-flex items-center lh-14 mb-5 has-skeleton">
                <div class="text-14 text-light-1">
                    @if(!empty($time = $row->start_time))
                        {{ __("Start Time: :time - ",['time'=>$time]) }}
                    @endif
                    {{duration_format($row->duration,true)}}
                </div>
            </div>
            <h4 class="activityCard__title text-dark-1 text-18 lh-16 fw-500 has-skeleton">
                <a class="text-dark-1-i" @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}"> <span>{{ $translation->title }}</span></a>
            </h4>
            @if(!empty($row->location->name))
                @php $location =  $row->location->translate() @endphp
            @endif
            <p class="text-light-1 lh-14 text-14 mt-5 has-skeleton">{{$location->name ?? ''}}</p>

            <div class="row justify-between items-center pt-15">
                <div class="col-auto">
                    @if(setting_item('event_enable_review'))
                            <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                        <div class="d-flex items-center has-skeleton">
                            @include('Layout::common.rating',['score_total'=>$score_total])
                            <div class="text-14 text-light-1 ml-5">
                                @if($reviewData['total_review'] > 1)
                                    {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                                @else
                                    {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-auto">
                    <div class="text-14 text-light-1 has-skeleton">
                        {{ __('from') }}
                        <span class="text-14  text-red-1 line-through d-inline-flex">{{ $row->display_sale_price }}</span>
                        <span class="fw-500 text-dark-1 d-inline-flex">{{ $row->display_price }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

