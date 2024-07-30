<section class="layout-pt-lg layout-pb-md tour-list-item">
    <div data-anim-wrap="" class="container animated">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end is-in-view">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>

            <div class="col-auto">
                <a href="{{ route('tour.search') }}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                    {{ __('More') }} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
        </div>

        <div class="relative overflow-hidden pt-40 sm:pt-20 js-section-slider" data-gap="30" data-scrollbar data-slider-cols="xl-4 lg-3 md-2 sm-2 base-1" data-nav-prev="js-hotels-prev" data-pagination="js-hotels-pag" data-nav-next="js-hotels-next">
            <div class="swiper-wrapper">

                @if(!empty($rows))
                    @php $delay = 1; @endphp
                    @foreach($rows as $k => $row)
                        <div data-anim-child="slide-up delay-{{$delay}}" class="swiper-slide">
                            @include('Tour::frontend.layouts.search.loop-grid')
                        </div>
                        @php $delay++; @endphp
                    @endforeach
                @endif
            </div>


            <div class="d-flex x-gap-15 items-center justify-center pt-40 sm:pt-20">
                <div class="col-auto">
                    <button class="d-flex items-center text-24 arrow-left-hover js-hotels-prev">
                        <i class="icon icon-arrow-left"></i>
                    </button>
                </div>

                <div class="col-auto">
                    <div class="pagination -dots text-border js-hotels-pag"></div>
                </div>

                <div class="col-auto">
                    <button class="d-flex items-center text-24 arrow-right-hover js-hotels-next">
                        <i class="icon icon-arrow-right"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>
