<section class="layout-pt-md layout-pb-md">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up" class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>

            <div class="col-auto">

                <div class="d-flex x-gap-15 items-center ">
                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-left-hover js-deals-prev">
                            <i class="icon icon-arrow-left"></i>
                        </button>
                    </div>

                    <div class="col-auto">
                        <div class="pagination -dots text-border js-deals-pag"></div>
                    </div>

                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-right-hover js-deals-next">
                            <i class="icon icon-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row y-gap-30 pt-40">
            <div data-anim-child="slide-up delay-2" class="col-xl-5">

                <div class="ctaCard -type-1 rounded-4 ">
                    <div class="ctaCard__image ratio ratio-63:55">
                        @if($book_img)
                            <img class="img-ratio js-lazy" src="#" data-src="{{get_file_url($book_img)}}" alt="image">
                        @endif
                    </div>

                    <div class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30">

                        <div class="text-15 fw-500 text-white mb-10">{{ $book_title ?? '' }}</div>


                        <h4 class="text-30 lg:text-24 text-white">{{ $book_desc ?? '' }}</h4>

                        @if($book_url_text)
                        <div class="d-inline-block mt-30">
                            <a href="{{$book_url}}" class="button px-48 py-15 -blue-1 -min-180 bg-white text-dark-1">{{$book_url_text ?? ''}}</a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            @if(!empty($rows))
                <div data-anim-child="slide-left delay-3" class="col-xl-7">
                    <div class="relative overflow-hidden js-section-slider" data-gap="30" data-scrollbar data-slider-cols="xl-3 lg-3 md-2 sm-2 base-1" data-nav-prev="js-deals-prev" data-pagination="js-deals-pag" data-nav-next="js-deals-next">
                        <div class="swiper-wrapper">
                            @foreach($rows as $row)
                                <div class="swiper-slide">
                                    @include('Tour::frontend.layouts.search.loop-grid')
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
