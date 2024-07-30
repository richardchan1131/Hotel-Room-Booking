@php $translation = $row->translate(); @endphp

<div class="border-top-light pt-30  {{$wrap_class ?? ''}}">
    <div class="row x-gap-20 y-gap-20">
        <div class="col-md-auto">
            <div class="has-skeleton">
                <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4 ">
                <div class="cardImage__content">
                    @if($row->image_url)
                        @if(!empty($disable_lazyload))
                            <img src="{{$row->image_url}}" class="img-responsive rounded-4 col-12" alt="{{ $translation->title }}">
                        @else
                            {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive rounded-4 col-12','alt'=>$translation->title, 'lazy' => false]) !!}
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
        </div>

        <div class="col-md ">
            @if(!empty($row->location->name))
                @php $location = $row->location->translate() @endphp
                <div class="text-14 text-light-1 has-skeleton">{{ $location->name ?? '' }}</div></a>
            @endif

            <h3 class="text-18 lh-16 fw-500 mt-5 has-skeleton">
                <a class="color-dark" href="{{ $row->getDetailUrl() }}"><span>{{ $translation->title }}</span></a>
            </h3>

            <div class="has-skeleton mt-30">
                <div class="row y-gap-15">
                    @if($row->max_guest)
                        <div class="col-auto">
                            <div class="text-14">{{ __("Max Guests") }}</div>
                            <div class="text-14 text-light-1">{{$row->max_guest}}</div>
                        </div>
                    @endif

                    @if($row->cabin)
                        <div class="col-auto">
                            <div class="text-14">{{__("Cabin")}}</div>
                            <div class="text-14 text-light-1">{{$row->cabin}}</div>
                        </div>
                    @endif

                    @if($row->length)
                        <div class="col-auto">
                            <div class="text-14">{{__("Length Boat")}}</div>
                            <div class="text-14 text-light-1">{{$row->length}}</div>
                        </div>
                    @endif

                    @if($row->speed)
                        <div class="col-auto">
                            <div class="text-14">{{__("Speed")}}</div>
                            <div class="text-14 text-light-1">{{$row->speed}}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-auto text-right md:text-left">
            <div class="has-skeleton">
                @if(setting_item('boat_enable_review'))
                    <div class="d-flex justify-content-md-end">
                            <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
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
                <div class="text-14 text-light-1 mt-20">{{ __("From") }}</div>
                <div class="text-22 lh-12 fw-600 mt-5">{{ format_money($row->min_price) }}</div>
                <div class="text-14 text-light-1 mt-5">{{ __("per adult") }}</div>
            </div>
            <div class="has-skeleton mt-24">
                <a href="{{ $row->getDetailUrl() }}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                    {{ __("View Detail") }} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
        </div>
    </div>
</div>
