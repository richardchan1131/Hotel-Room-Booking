<section class="layout-pt-md layout-pb-lg bravo-list-locations {{$layout ?? ''}}">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="row y-gap-40 justify-between pt-40 sm:pt-20">
            @if($rows)
                @foreach($rows as $k => $row)
                    @php $translation = $row->translate();
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
                    <div data-anim-child="slide-up delay-{{$k+1}}" class="@if($k > 1) col-xl-3 @else col-xl-6 @endif col-md-4 col-sm-6 item">
                        @if(!empty($link_location)) <a href="{{ $link_location }}"> @endif
                            <div class="citiesCard -type-3 rounded-4 d-inline">
                                <div class="citiesCard__image">
                                    <img class="col-12 js-lazy" src="#" data-src="{{get_file_url($row->image_id)}}" alt="image">
                                </div>
                                <div class="citiesCard__content px-30 py-30">
                                    <h4 class="text-26 fw-600 text-white">{{ $translation->name }}</h4>
                                    <div class="text-15 text-white">
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
                        @if(!empty($link_location)) </a> @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
