@php
    /**
    * @var $row \Modules\Location\Models\Location
    * @var $to_location_detail bool
    * @var $service_type string
    */
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
<div class="swiper-slide">
    <span class="citiesCard -type-1 d-block rounded-4 ">
        @if(!empty($link_location)) <a href="{{$link_location}}"> @endif
            <div class="citiesCard__image ratio ratio-3:4">
                @if($row->image_id)
                    <img src="#" data-src="{{ $row->getImageUrl() }}" alt="{{ $translation->name ?? '' }}" class="js-lazy">
                @endif
            </div>
            <div class="citiesCard__content d-flex flex-column justify-between text-center pt-30 pb-20 px-20">
                <div class="citiesCard__bg"></div>
                <div class="citiesCard__top">
                    @if( !empty($layout) and $layout == "style_1")
                        @if(is_array($service_type))
                            <div class="text-14 text-white">
                                @foreach($service_type as $k => $type)
                                    @php $count = $row->getDisplayNumberServiceInLocation($type) @endphp
                                    @if(!empty($count))
                                        @if(empty($link_location))
                                            <a href="{{ $row->getLinkForPageSearch( $type ) }}" target="_blank" class="d-inline-block me-2">
                                                {{$count}}
                                            </a>
                                        @else
                                            <span class="d-inline-block">{{$count}}</span>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @else
                            @if(!empty($text_service = $row->getDisplayNumberServiceInLocation($service_type)))
                                <div class="text-14 text-white">{{$text_service}}</div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="citiesCard__bottom">
                    <h4 class="text-26 md:text-20 lh-13 text-white mb-20">{{$translation->name}}</h4>
                    @if(!empty($link_location))
                        <button class="button col-12 h-60 -blue-1 bg-white text-dark-1" onclick="window.open('{{$row->getDetailUrl()}}','_self')">{{ __('Discover') }}</button>
                    @endif
                </div>
            </div>
            @if(!empty($link_location)) </a> @endif
    </span>
</div>
