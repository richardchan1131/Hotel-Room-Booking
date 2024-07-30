<section class="layout-pt-md layout-pb-lg">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="row y-gap-30 pt-40">
            @if($rows)
                @php $index = 2; @endphp
                @foreach($rows as $key => $row)
                    @php
                        $translation = $row->translate();
                    @endphp
                    <div data-anim-child="slide-up delay-{{ $index }}" class="col-xl-2 col-lg-3 col-sm-6">
                        @if($to_location_detail) <a href="{{$row->getDetailUrl()}}"> @endif
                            <div class="citiesCard -type-4 d-block text-center">
                                <div class="citiesCard__image size-160 rounded-full mx-auto">
                                    <img class="object-cover js-lazy" data-src="{{ $row->getImageUrl() }}" src="{{ $row->getImageUrl() }}" alt="{{ $translation->name }}">
                                </div>
                                <div class="citiesCard__content mt-10">
                                    <h4 class="text-18 lh-13 fw-500 text-dark-1">{{ $translation->name }}</h4>
                                    @if(is_array($service_type))
                                        @php $count_all = 0; @endphp
                                        @foreach($service_type as $k => $type)
                                            @php $count_all += (int) $row->getDisplayNumberServiceInLocation($type) @endphp
                                        @endforeach
                                        @if(!empty($count_all))
                                            <span class="text-14 text-light-1">{{$count_all}} {{ __("travellers") }}</span>
                                        @endif
                                    @else
                                        @if(!empty($text_service = $row->getDisplayNumberServiceInLocation($service_type)))
                                            <span class="text-14 text-light-1">{{$text_service}}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @if($to_location_detail) </a> @endif
                    </div>
                    @php $index++; if($key == 7) $index = 2; @endphp
                @endforeach
            @endif
        </div>
    </div>
</section>
