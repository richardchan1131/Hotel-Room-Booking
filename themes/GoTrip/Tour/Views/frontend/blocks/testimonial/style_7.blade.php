@if(!empty($list_item))
    <section class="section-bg layout-pt-lg layout-pb-lg bg-light-2">
        <div class="section-bg__item col-12">
            <img src="{{ get_file_url($testimonial_bg, 'full') }}" alt="image">
        </div>

        <div class="container">
            <div class="row justify-center pt-50 md:pt-30">
                <div class="col-xl-7 col-lg-10">
                    <div class="overflow-hidden js-section-slider" data-pagination="js-testimonials-pag" data-slider-cols="base-1">
                        <div class="swiper-wrapper">

                            @foreach($list_item as $item)
                                <div class="swiper-slide">
                                    <div class="text-center">
                                        <div class="mb-40">
                                            <img src="{{get_file_url($item['avatar'])}}" alt="{{ $item['name'] }}">
                                        </div>
                                        @if(!empty($item['title']))
                                            <div class="text-25 md:text-22 fw-600 text-white mb-10">{{ $item['title'] }}</div>
                                        @endif
                                        <div class="text-22 md:text-18 fw-600 text-white">
                                            {{ $item['desc'] }}
                                        </div>

                                        <div class="text-white mt-40 sm:mt-30">
                                            <h5 class="text-15 lh-15 fw-500">{{ $item['name'] }}</h5>
                                            <div class="text-14">{{$item['job']}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-40 lg:pt-40 sm:pt-30">

                            <div class="d-flex x-gap-15 items-center justify-center pt-30">
                                <div class="col-auto">
                                    <button class="d-flex items-center text-24 arrow-left-hover text-white js-prev">
                                        <i class="icon icon-arrow-left"></i>
                                    </button>
                                </div>

                                <div class="col-auto">
                                    <div class="pagination -dots text-white-50 js-testimonials-pag"></div>
                                </div>

                                <div class="col-auto">
                                    <button class="d-flex items-center text-24 arrow-right-hover text-white js-next">
                                        <i class="icon icon-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
