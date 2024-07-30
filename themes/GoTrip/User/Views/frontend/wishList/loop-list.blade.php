<?php
$service = $row->service;
?>
@if(!empty($service))
    @php
        $service = $row->service;
        $translation = $service->translate();
        $layout_style = $layout_style ?? '';
    @endphp
    <div class="border-bottom-light pb-20">
        <div class="row x-gap-20 y-gap-30">
            <div class="col-md-auto">
                <div class="cardImage ratio ratio-1:1 w-200 md:w-1/1 rounded-4">
                    <div class="cardImage__content">
                        <img  src="{{$service->image_url}}" class="rounded-4 js-lazy" alt="{{ $translation->title }}">
                    </div>
                    <div class="service-wishlist {{$service->isWishList()}}" data-id="{{ $service->id }}" data-type="{{ $service->type }}">
                        <div class="cardImage__wishlist">
                            <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                                <i class="icon-heart text-12"></i>
                            </button>
                        </div>
                    </div>
                    @if($service->is_featured == "1")
                        <div class="cardImage__leftBadge">
                            <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">
                                {{__("Featured")}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md">
                <a href="{{ $service->getDetailUrl() }}" class="text-18 lh-14 fw-500 text-dark-1">{{ $translation->title }}</a>
                @if($service->getReviewEnable())
                    <div class="rate  pt-10">
                            <?php $reviewData = $service->getScoreReview(); $score_total = $reviewData['score_total'];?>
                        @include('Layout::common.rating',['score_total'=>$score_total])
                    </div>
                @endif
                <div class="pt-10 text-dark-1">
                    <i class="icofont-license"></i>
                    {{__("Service Type")}}: <span class="badge badge-info">{{$service->getModelName() ?? ''}}</span>
                </div>
                <div class="pt-5 text-dark-1">
                    @if(!empty($service->location->name))
                        <i class="icofont-paper-plane"></i>
                        {{__("Location")}}: {{$service->location->name ?? ''}}
                    @endif
                </div>
            </div>
            <div class="col-md-auto text-right md:text-left">
                <div class="d-flex flex-column justify-between h-full">
                    @if($service->getReviewEnable())
                        <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                            <div class="col-auto">
                                <div class="text-14 lh-14 fw-500">
                                    {{ $reviewData['review_text'] ?? "" }}
                                </div>
                                <div class="text-14 lh-14 text-light-1">
                                    @if($reviewData['total_review'] > 1)
                                        {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                                    @else
                                        {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1">{{$score_total}}</div>
                            </div>
                        </div>
                    @endif
                    <div class="pt-24">
                        <div class="fw-500">{{ __("Starting from") }}</div>
                        <span class="fw-500 text-blue-1 text-20">
                            <span class="sale-price">{{ $service->display_sale_price }}</span>
                            {{ $service->display_price }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
