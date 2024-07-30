@if(!empty($list_item))
    <section class="section-bg layout-pt-lg layout-pb-lg bg-light-2">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                    </div>
                </div>
            </div>

            <div data-anim-child="slide-up delay-2" class="row justify-center pt-50 md:pt-30">
                <div class="col-xl-7 col-lg-10">
                    <div class="overflow-hidden js-testimonials-slider">
                        <div class="swiper-wrapper">
                            @foreach($list_item as $item)
                                <div class="swiper-slide">
                                    <div class="testimonials -type-2 text-center">
                                        <div class="mb-40">
                                            <img src="{{ asset('themes/gotrip/images/quote-1.svg') }}" alt="quote">
                                        </div>

                                        <div class="text-22 md:text-18 fw-600 text-dark-1">{{ $item['desc'] ?? '' }}</div>

                                        <div class="mt-40">
                                            <h5 class="text-17 lh-15 fw-500">{{ $item['name'] ?? '' }}</h5>
                                            <div class="">{{ $item['job'] ?? '' }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-60 lg:pt-40">
                            <div class="pagination -avatars row x-gap-40 y-gap-20 justify-center js-testimonials-pagination">
                                @foreach($list_item as $k => $item)
                                    <div class="col-auto">
                                        <div class="pagination__item @if(!$k) is-active @endif">
                                            <img src="{{ get_file_url($item['avatar']) }}" alt="image">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
