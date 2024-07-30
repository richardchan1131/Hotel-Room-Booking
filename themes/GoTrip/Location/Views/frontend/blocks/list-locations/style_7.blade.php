<section class="layout-pt-xl layout-pb-md">
    <div class="container">
        <div class="row y-gap-20 justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>

        <div class="row y-gap-30 pt-40">
            @if($rows)
                @foreach($rows as $row)
                    @php $translation = $row->translate() @endphp
                    <div class="w-1/5 lg:w-1/3 sm:w-1/2">
                        <a href="{{$row->getDetailUrl()}}">
                            <div class="citiesCard -type-2 ">
                                <div class="citiesCard__image rounded-4 ratio ratio-23:18">
                                    <img class="img-ratio rounded-4 js-lazy" data-src="{{ get_file_url($row->image_id) }}" src="#" alt="{{ $translation->name ?? '' }}">
                                </div>
                                <div class="citiesCard__content mt-10">
                                    <h4 class="text-18 lh-13 fw-500 text-dark-1">{{ $translation->name ?? '' }}</h4>
                                    @if(is_array($service_type))
                                        @php $count_all = 0; @endphp
                                        @foreach($service_type as $k => $type)
                                            @php $count_all += (int) $row->getDisplayNumberServiceInLocation($type) @endphp
                                        @endforeach
                                        @if(!empty($count_all))
                                            <span>{{$count_all}} {{ __("travellers") }}</span>
                                        @endif
                                    @else
                                        @if(!empty($text_service = $row->getDisplayNumberServiceInLocation($service_type)))
                                            <span>{{$text_service}}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
