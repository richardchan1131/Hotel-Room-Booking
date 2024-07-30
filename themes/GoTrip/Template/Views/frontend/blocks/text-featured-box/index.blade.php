<section class="layout-pt-lg layout-pb-md">
    <div class="container">
        <div class="row y-gap-30 justify-between items-center">
            <div class="col-xl-5 col-lg-6">
                <h2 class="text-30 fw-600">{{ $title ?? '' }}</h2>
                <p class="mt-40 lg:mt-20">{{ $desc ?? '' }}</p>

                <div class="d-inline-block mt-40 lg:mt-20">

                    @if(!empty($link_title) && !empty($link_more))
                        <a href="{{ $link_more }}" class="button -md -blue-1 bg-dark-1 text-white">
                            {{ $link_title }} <div class="icon-arrow-top-right ml-15"></div>
                        </a>
                    @endif

                </div>
            </div>

            @if(!empty($list_item))
            <div class="col-xl-5 col-lg-6">
                <div class="shadow-4">
                    <div class="row border-center">

                        @foreach($list_item as $key => $val)
                        <div class="col-sm-6">
                            <div class="py-60 sm:py-30 text-center">
                                <div class="text-40 lg:text-30 lh-13 text-dark-1 fw-600">{{ $val['number'] }}</div>
                                <div class="text-14 lh-14 text-light-1 mt-10">{{ $val['title'] }}</div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
