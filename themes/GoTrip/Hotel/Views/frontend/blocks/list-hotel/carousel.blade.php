<section class="layout-pt-md layout-pb-md bravo-gotrip-list-hotel layout_{{$style_list}}">
    <div data-anim="slide-up delay-1" class="container">
        <div class="row y-gap-10 @if($style_list == 'carousel_v2') justify-center @else justify-between @endif items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc}}</p>
                </div>
            </div>
        </div>

        <div class="relative @if($style_list == 'carousel') overflow-hidden @endif pt-40 sm:pt-20 js-section-slider" data-gap="30" data-scrollbar data-slider-cols="xl-4 lg-3 md-2 sm-2 base-1" data-nav-prev="js-hotels-prev" data-pagination="js-hotels-pag" data-nav-next="js-hotels-next">
            <div class="swiper-wrapper">
                @foreach($rows as $row)
                    <div class="swiper-slide">
                        @include('Hotel::frontend.layouts.search.loop-grid')
                    </div>
                @endforeach
            </div>
            @if($style_list == 'carousel_v2')
                <button class="section-slider-nav -prev flex-center button -blue-1 bg-white shadow-1 size-40 rounded-full sm:d-none js-hotels-prev">
                    <i class="icon icon-chevron-left text-12"></i>
                </button>
                <button class="section-slider-nav -next flex-center button -blue-1 bg-white shadow-1 size-40 rounded-full sm:d-none js-hotels-next">
                    <i class="icon icon-chevron-right text-12"></i>
                </button>
            @else
                <div class="d-flex x-gap-15 items-center justify-center sm:justify-start pt-40 sm:pt-20">
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
            @endif

        </div>
    </div>
</section>
