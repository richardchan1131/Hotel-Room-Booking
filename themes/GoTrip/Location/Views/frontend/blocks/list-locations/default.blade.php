<section class="layout-pt-lg layout-pb-md bravo-list-locations @if(!empty($layout)) {{ $layout }} @endif">
    <div class="container">
        <div data-anim="slide-up delay-1" class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc}}</p>
                </div>
            </div>

            @if(!empty($view_all_url))
                <div class="col-auto md:d-none">
                    <a href="{{ $view_all_url }}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                        {{ __('View All Destinations') }} <div class="icon-arrow-top-right ml-15"></div>
                    </a>
                </div>
            @endif
        </div>

        <div class="relative pt-40 sm:pt-20 js-section-slider" data-gap="30" data-scrollbar data-slider-cols="base-2 xl-4 lg-3 md-2 sm-2 base-1" data-anim="slide-up delay-2">
            <div class="swiper-wrapper">
                @if($rows)
                    @foreach($rows as $row)
                        @include('Location::frontend.blocks.list-locations.loop')
                    @endforeach
                @endif
            </div>


            <button class="section-slider-nav -prev flex-center button -blue-1 bg-white shadow-1 size-40 rounded-full sm:d-none js-prev">
                <i class="icon icon-chevron-left text-12"></i>
            </button>

            <button class="section-slider-nav -next flex-center button -blue-1 bg-white shadow-1 size-40 rounded-full sm:d-none js-next">
                <i class="icon icon-chevron-right text-12"></i>
            </button>


            <div class="slider-scrollbar bg-light-2 mt-40 sm:d-none js-scrollbar"></div>

            @if(!empty($view_all_url))
                <div class="row pt-20 d-none md:d-block">
                    <div class="col-auto">
                        <div class="d-inline-block">
                            <a href="{{ $view_all_url }}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                                {{ __('View All Destinations') }} <div class="icon-arrow-top-right ml-15"></div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
