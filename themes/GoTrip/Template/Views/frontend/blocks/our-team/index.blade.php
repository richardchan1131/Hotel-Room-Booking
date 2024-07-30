<section class="bravo-our-team layout-pt-lg layout-pb-lg">
    <div class="container">
        <div class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? "" }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? "" }}</p>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex x-gap-15 items-center justify-center">
                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-left-hover js-team-prev">
                            <i class="icon icon-arrow-left"></i>
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="pagination -dots text-border js-team-pag"></div>
                    </div>
                    <div class="col-auto">
                        <button class="d-flex items-center text-24 arrow-right-hover js-team-next">
                            <i class="icon icon-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($list_item))
            <div class="overflow-hidden pt-40 js-section-slider" data-gap="30" data-slider-cols="xl-5 lg-4 md-2 sm-2 base-1" data-nav-prev="js-team-prev" data-pagination="js-team-pag" data-nav-next="js-team-next">
            <div class="swiper-wrapper">
                @foreach($list_item as $item)
                    <div class="swiper-slide">
                        <div class="">
                            <img src="{{ get_file_url($item['avatar'],'full') }}" alt="{{ $item['name'] }}" class="rounded-4 col-12">
                            <div class="mt-10">
                                <div class="text-18 lh-15 fw-500">{{ $item['name'] }}</div>
                                <div class="text-14 lh-15">{{ $item['job'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
