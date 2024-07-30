<section data-anim-wrap class="bravo-form-search-space masthead -type-7">
    <div class="masthead-slider js-masthead-slider-7">
        <div class="swiper-wrapper">
            @if(!empty($list_slider))
                @foreach($list_slider as $item)
                    <div class="swiper-slide">
                        <div class="row justify-center text-center">
                            <div class="col-auto">
                                <div class="masthead__content">
                                    <div class="masthead__bg">
                                        <img src="{{ get_file_url($item['bg_image'],'full') }}" alt="image">
                                    </div>

                                    <div data-anim-child="slide-up delay-1" class="text-white">
                                        {{ $item['sub_title'] ?? '' }}
                                    </div>

                                    <h1 data-anim-child="slide-up delay-2" class="text-60 lg:text-40 md:text-30 text-white">
                                        {!! $item['title'] ?? '' !!}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="masthead-slider__nav -prev js-prev">
            <button class="button -outline-white text-white size-50 rounded-full">
                <i class="icon-arrow-left"></i>
            </button>
        </div>

        <div class="masthead-slider__nav -next js-next">
            <button class="button -outline-white text-white size-50 rounded-full">
                <i class="icon-arrow-right"></i>
            </button>
        </div>
    </div>
    @include('Space::frontend.layouts.search.form-search',['style' => 'space_form_search'])
</section>
