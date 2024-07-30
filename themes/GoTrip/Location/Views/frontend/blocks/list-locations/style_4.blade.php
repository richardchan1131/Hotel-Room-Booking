<section class="layout-pt-md layout-pb-md bravo-list-locations @if(!empty($layout)) {{ $layout }} @endif">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc}}</p>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex x-gap-15 items-center justify-center pt-40 sm:pt-20">
                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-left-hover js-places-prev">
                            <i class="icon icon-arrow-left"></i>
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="pagination -dots text-border js-places-pag"></div>
                    </div>
                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-right-hover js-places-next">
                            <i class="icon icon-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-40 overflow-hidden js-section-slider" data-gap="30" data-slider-cols="xl-5 lg-3 md-2 sm-2 base-1" data-nav-prev="js-places-prev" data-pagination="js-places-pag" data-nav-next="js-places-next">
            <div class="swiper-wrapper">
                @if($rows)
                    @foreach($rows as $key => $row)
                        @php
                            $translation = $row->translate();
                            $link_location = false;
                            if(is_string($service_type)){
                                $link_location = $row->getLinkForPageSearch($service_type);
                            }
                            if(is_array($service_type) and count($service_type) == 1){
                                $link_location = $row->getLinkForPageSearch($service_type[0] ?? "");
                            }
                            if($to_location_detail){
                                $link_location = $row->getDetailUrl();
                            }
                        @endphp
                        <div data-anim-child="slide-left delay-{{$key + 3}}" class="swiper-slide">
                            @if($to_location_detail)
                                <a href="{{ $link_location }}">
                            @endif
                                <div class="citiesCard -type-2">
                                    <div class="citiesCard__image rounded-4 ratio ratio-3:4">
                                        <img class="img-ratio rounded-4 js-lazy" data-src="{{$row->getImageUrl()}}" src="#" alt="{{ $translation->name ?? '' }}">
                                    </div>
                                    <div class="citiesCard__content mt-10">
                                        <h4 class="text-18 lh-13 fw-500 text-dark-1">{{$translation->name}}</h4>
                                        <div class="text-14 text-light-1">
                                            @if(is_array($service_type))
                                                @foreach($service_type as $k => $type)
                                                    @php $count = $row->getDisplayNumberServiceInLocation($type) @endphp
                                                    @if(!empty($count))
                                                        @if(empty($link_location))
                                                            <a href="{{ $row->getLinkForPageSearch( $type ) }}" target="_blank">
                                                                <span class="me-2">{{$count}}</span>
                                                            </a>
                                                        @else
                                                            <span class="me-2">{{$count}}</span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                                @if(!empty($text_service = $row->getDisplayNumberServiceInLocation($service_type)))
                                                    <span class="me-2">{{$text_service}}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @if($to_location_detail) </a> @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
