@php
    $translation = $row->translate();
    $reviewData = $row->getScoreReview();
    $score_total = $reviewData['score_total'];
@endphp
<div class="border-top-light pt-30 {{$wrap_class ?? ''}}">
    <div class="row x-gap-20 y-gap-20">
        <div class="col-md-auto">
            <div class="has-skeleton">
            <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                <div class="cardImage__content">
                    <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" >
                        @if($row->image_url)
                            @if(!empty($disable_lazyload))
                                <img src="{{$row->image_url}}" class="img-responsive rounded-4 col-12" alt="{{ $translation->title }}">
                            @else
                                {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive rounded-4 col-12','alt'=>$translation->title, 'lazy' => false]) !!}
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

        <div class="col-md">
            <div class="row x-gap-10 items-center ">
                @if(setting_item('event_enable_review'))
                    <div class="col-auto">
                        <p class="text-14 lh-14 mb-5 has-skeleton">{{ $reviewData['review_text'] }} {{ $score_total  }}</p>
                    </div>
                    <div class="col-auto">
                        <div class="size-3 rounded-full bg-light-1 mb-5"></div>
                    </div>
                @endif
                <div class="col-auto">
                    <p class="text-14 lh-14 mb-5 has-skeleton">{{__(":number% of guests recommend",['number'=>$row->recommend_percent])}}</p>
                </div>
            </div>
            <h3 class="text-18 lh-16 fw-500 has-skeleton"><a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" >{{ $translation->title }}</a></h3>
            @if(!empty($row->location->name))
                @php $location =  $row->location->translate() @endphp
            @endif
            <p class="text-14 lh-14 mt-5 has-skeleton">{{$location->name ?? ''}}</p>

            @if(!empty($time = $row->start_time))
                <div class="text-14 lh-15 fw-500 mt-20 has-skeleton">
                    {{ __("Start Time: :time",['time'=>$time]) }}
                </div>
            @endif

            <div class="text-14 text-green-2 fw-500 lh-15 mt-5 has-skeleton">
                {{ __("Duration:") }} {{duration_format($row->duration)}}
            </div>

        </div>

        <div class="col-md-auto text-right md:text-left">
            <div class="has-skeleton">
                @if(setting_item('event_enable_review'))
                    <div class="d-flex justify-content-md-end">
                        @include('Layout::common.rating',['score_total'=>$score_total])
                    </div>
                    <div class="text-14 lh-14 text-light-1 mt-10">
                        @if($reviewData['total_review'] > 1)
                            {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                        @else
                            {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                        @endif
                    </div>
                @endif
                <div class="text-14 text-light-1 mt-30 md:mt-20">{{ __('Starting from') }}</div>
                <div class="d-flex justify-content-md-end align-baseline mt-5">
                    <div class="text-16 text-red-1 line-through mr-5">{{ $row->display_sale_price }}</div>
                    <div class="text-22 lh-12 fw-600">{{ $row->display_price }}</div>
                </div>
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}" class="button -md -dark-1 bg-blue-1 text-white mt-24">
                    {{__('View Detail')}} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
        </div>
    </div>
</div>
