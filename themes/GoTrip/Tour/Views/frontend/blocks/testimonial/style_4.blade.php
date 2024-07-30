@if(!empty($list_item))
<section class="section-bg layout-pt-lg layout-pb-md">
    <div class="section-bg__item col-12">
        <img src="{{ get_file_url($testimonial_bg,'full') }}" alt="image">
    </div>

    <div data-anim="slide-up delay-1" class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                </div>
            </div>
        </div>


        <div class="row justify-center pt-60 md:pt-30">
            <div class="col-xl-5 col-lg-8 col-md-11">
                <div class="overflow-hidden js-section-slider" data-slider-cols="base-1" data-gap="30" data-pagination="js-testimonials-pag">
                    <div class="swiper-wrapper">
                        @foreach($list_item as $item)
                        <div class="swiper-slide">
                            <div class="testimonials -type-2 text-center">
                                <div class="testimonials__image mb-24 md:mb-20">
                                    <img src="{{ asset('themes/gotrip/images/quote.svg') }}" alt="quote">
                                    <img src="{{ get_file_url($item['avatar']) }}" alt="quote">
                                </div>

                                <h4 class="text-16 fw-500 text-blue-1">{{ $item['title'] ?? '' }}</h4>
                                <div class="fw-500 text-dark-1 mt-20">{{ $item['desc'] ?? '' }}</div>

                                <div class="testimonials__author mt-40">
                                    <h5 class="text-15 lh-14 fw-500">{{ $item['name'] ?? '' }}</h5>
                                    <div class="text-14 text-light-1 mt-5">{{ $item['job'] ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>


                    <div class="d-flex x-gap-15 items-center justify-center pt-40 sm:pt-20">
                        <div class="col-auto">
                            <button class="d-flex items-center text-24 arrow-left-hover js-prev">
                                <i class="icon icon-arrow-left"></i>
                            </button>
                        </div>

                        <div class="col-auto">
                            <div class="pagination -dots text-border js-testimonials-pag"></div>
                        </div>

                        <div class="col-auto">
                            <button class="d-flex items-center text-24 arrow-right-hover js-next">
                                <i class="icon icon-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endif

<section class="layout-pt-lg layout-pb-md">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="text-15 lh-1">{{ $title_trusted ?? '' }}</div>
            </div>
        </div>

        @if($list_trusted)
        <div class="row y-gap-40 justify-between items-center pt-60 lg:pt-40 sm:pt-20">
            @foreach($list_trusted as $item)
                <div class="col-md-auto col-6">
                    <div class="d-flex justify-center">
                        <img src="{{ get_file_url($item['avatar']) }}" alt="image">
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
