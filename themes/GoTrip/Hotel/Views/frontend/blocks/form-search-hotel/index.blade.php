@if(!empty($list_item))
    <div class="form-search-all-service home4-form-search-hotel">
        <div class="tabs__content">
            <section data-anim-wrap class="masthead -type-4 {{ $style ?? '' }}">
                <div data-anim-child="slide-up" class="masthead-slider overflow-x-hidden js-masthead-slider-4">
                    <div class="swiper-wrapper">
                        @foreach($list_item as $item)
                            <div class="swiper-slide">
                                <div class="masthead__image">
                                    <img src="{{ get_file_url($item['bg_image'],'full') }}" alt="{{ $item['title'] }}">
                                </div>

                                <div class="container">
                                    <div class="row justify-center">
                                        <div class="col-xl-9">
                                            <div class="masthead__content">
                                                <div class="text-center content-wrap">
                                                    <h1 data-anim-child="slide-up delay-2" class="text-60 lg:text-40 md:text-30 text-white">{{ $item['title'] }}</h1>
                                                    <p data-anim-child="slide-up delay-3" class="text-white mt-5">{{ $item['sub_title'] }}</p>

                                                    @if($item['discover_text'])
                                                        <div data-anim-child="slide-up delay-4" class="d-inline-block">
                                                            <a href="{{ $item['discover_link'] }}" class="button -md -outline-white h-50 text-white mt-30">{{ $item['discover_text'] }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="masthead-slider__nav -prev js-prev">
                        <button class="button -outline-white size-50 flex-center text-white rounded-full">
                            <i class="icon-arrow-left"></i>
                        </button>
                    </div>

                    <div class="masthead-slider__nav -next js-next">
                        <button class="button -outline-white size-50 flex-center text-white rounded-full">
                            <i class="icon-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="masthead__scroll">
                    <div class="text-14 text-white">{{ __('Scroll Now') }}</div>
                    <div class="-line"></div>
                </div>
            </section>
            @include('Hotel::frontend.layouts.search.form-search',['style' => 'hotel_carousel'])
        </div>
    </div>
@endif
