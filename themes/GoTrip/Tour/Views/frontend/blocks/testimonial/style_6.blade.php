@if(!empty($list_item))
<section class="section-bg rounded-4 overflow-hidden">
    <div class="section-bg__item -left-100 -right-100 bg-blue-2"></div>

    <div class="section-bg__item col-4 -right-100 lg:d-none">
        <img src="{{ get_file_url($testimonial_bg,'full') }}" alt="image">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-8">
                <div class="pt-120 pb-120 lg:pt-80 lg:pb-80">
                    <h2 class="text-30 fw-600">{{ $title ?? '' }}</h2>
                    <p class="mt-5">{{ $subtitle ?? '' }}</p>

                    <div class="overflow-hidden pt-60 lg:pt-40 js-section-slider" data-slider-cols="base-1">
                        <div class="swiper-wrapper">

                            @foreach($list_item as $item)
                                <div class="swiper-slide">
                                    <div class="testimonials -type-2">
                                        <img src="{{ asset('themes/gotrip/images/quote-1.svg') }}" alt="quote" class="mb-35">
                                        <div class="text-22 md:text-18 fw-600 text-dark-1">{{ $item['desc'] }}</div>

                                        <div class="d-flex items-center mt-35">
                                            <img src="{{get_file_url($item['avatar'])}}" alt="{{$item['name']}}" class="size-70">
                                            <div class="ml-20">
                                                <h5 class="text-15 lh-11 fw-500">{{ $item['name'] }}</h5>
                                                <div class="text-14 lh-11 mt-5">{{$item['job']}}</div>
                                            </div>
                                        </div>
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
