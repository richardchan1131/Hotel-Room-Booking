@if(!empty($list_item))
<section class="layout-pt-lg layout-pb-lg bg-dark-1">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle text-white">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                </div>
            </div>
        </div>

        <div data-anim-child="slide-up delay-2" class="overflow-hidden pt-60 lg:pt-40 sm:pt-30 js-section-slider" data-gap="30" data-slider-cols="xl-3 lg-3 md-2 sm-1 base-1">
            <div class="swiper-wrapper">

                @foreach($list_item as $item)
                    <div class="swiper-slide">
                        <div class="testimonials -type-1 bg-white rounded-4 pt-40 pb-30 px-40">
                            <h4 class="text-16 fw-500 text-blue-1 mb-20">{{ $item['title'] }}</h4>
                            <p class="testimonials__text lh-18 fw-500 text-dark-1">{{ $item['desc'] }}</p>

                            <div class="pt-20 mt-28 border-top-light">
                                <div class="row x-gap-20 y-gap-20 items-center">
                                    <div class="col-auto">
                                        <img class="size-60" src="{{get_file_url($item['avatar'])}}" alt="{{$item['name']}}">
                                    </div>

                                    <div class="col-auto">
                                        <div class="text-15 fw-500 lh-14">{{ $item['name'] }}</div>
                                        <div class="text-14 lh-14 text-light-1 mt-5"> {{$item['job']}} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <div data-anim-child="slide-up delay-3" class="row y-gap-40 items-center pt-40 sm:pt-20">
            <div class="col-xl-4">
                <div class="row y-gap-30 text-white sm:text-center">
                    <div class="col-sm-5 col-6">
                        <div class="text-30 lh-15 fw-600">{{ $happy_people_number ?? '' }}</div>
                        <div class="lh-15">{{ $happy_people_text ?? '' }}</div>
                    </div>

                    <div class="col-sm-5 col-6">
                        <div class="text-30 lh-15 fw-600">{{ $overall_rating_number ?? '' }}</div>
                        <div class="lh-15">{{ $overall_rating_text ?? '' }}</div>

                        @if(!empty($overall_rating_star))
                            <div class="d-flex x-gap-5 items-center sm:justify-center pt-10">
                                @for($i = 1; $i <= $overall_rating_star; $i++)
                                    <div class="icon-star text-white text-10"></div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!empty($list_trusted))
                <div class="col-xl-8">
                    <div class="row y-gap-30 justify-between items-center">

                        @foreach($list_trusted as $key => $val)
                        <div class="col-md-auto col-6">
                            <div class="d-flex justify-center">
                                <img src="{{ get_file_url($val['avatar']) }}" alt="image">
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif
