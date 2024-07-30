<section class="layout-pt-md layout-pb-md bravo-list-locations @if(!empty($layout)) {{ $layout }} @endif">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>

            @if(!empty($view_all_url))
            <div class="col-auto">
                <a href="{{$view_all_url}}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                    {{ __('More') }} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
            @endif
        </div>

        @if(!empty($rows))
            <div class="row y-gap-30 pt-40 sm:pt-20">
                @php $delay = 2; @endphp
                @foreach($rows as $row)
                    @php $translation = $row->translate(); @endphp
                    <div data-anim-child="slide-up delay-{{$delay}}" class="col-xl-3 col-lg-4 col-md-6">
                        <a href="{{ $row->getDetailUrl() }}" class="destCard -type-1 d-block">
                            <div class="row x-gap-20 y-gap-20 items-center">
                                <div class="col-auto">
                                    <div class="destCard__image rounded-4">
                                        @if($row->image_id)
                                        <img class="size-100 rounded-4" src="{{ get_file_url($row->image_id) }}" alt="{{ $translation->name ?? '' }}">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="text-18 fw-500">{{$translation->name}}</div>
                                    @if(is_array($service_type))
                                        @php $count_all = 0; @endphp
                                        @foreach($service_type as $k => $type)
                                            @php $count_all += (int) $row->getDisplayNumberServiceInLocation($type) @endphp
                                        @endforeach
                                        @if(!empty($count_all))
                                            <span class="text-14 lh-14 text-light-1 mt-5">{{$count_all}} {{ __("travellers") }}</span>
                                        @endif
                                    @else
                                        @if(!empty($text_service = $row->getDisplayNumberServiceInLocation($service_type)))
                                            <span class="text-14 lh-14 text-light-1 mt-5">{{$text_service}}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @php $delay++ @endphp
                @endforeach
            </div>
        @endif
    </div>
</section>
