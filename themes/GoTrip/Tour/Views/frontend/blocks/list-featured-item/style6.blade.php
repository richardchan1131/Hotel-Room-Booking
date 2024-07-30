<section class="layout-pt-lg layout-pb-md">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-30">
            <div class="col-xl-4 col-lg-5">
                <h2 class="text-30 fw-600">{{ $title ?? '' }}</h2>
                @if($sub_title)
                    <p class="mt-5">{{ $sub_title }}</p>
                @endif

                @if($description)
                    <p class="text-dark-1 mt-40 sm:mt-20">{{ $description }}</p>
                @endif

                @if(!empty($link_title))
                <div class="d-inline-block mt-40 sm:mt-20">

                    <a href="{{ $link_more ?? '' }}" class="button -md -blue-1 bg-yellow-1 text-dark-1">
                        {{ $link_title }} <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
                @endif
            </div>

            <div class="col-xl-6 offset-xl-1 col-lg-7">
                <div class="row y-gap-60">

                    @if(!empty($list_item))
                        @foreach($list_item as $k => $item)
                            <?php $image_url = get_file_url($item['icon_image'], 'full') ?>

                            <div data-anim-child="slide-up delay-{{ $k + 3 }}" class="col-sm-6">
                                @if(!empty($image_url))
                                    <img class="size-60" src="{{$image_url}}" alt="{{$item['title'] ?? ''}}">
                                @endif
                                <h5 class="text-18 fw-500 mt-10">{{$item['title'] ?? ''}}</h5>
                                <p class="mt-10">{{$item['sub_title'] ?? ''}}</p>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
