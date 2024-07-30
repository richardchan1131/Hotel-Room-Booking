<section class="section-bg layout-pt-lg layout-pb-lg md:pt-0 md:pb-60 sm:pb-40 bg-blue-2">
    <div class="section-bg__item -right -image col-5 md:mb-60 sm:mb-40 d-flex z-2">
        <img src="{{  get_file_url($youtube_image ?? "" , 'full') }}" alt="{{ $title ?? '' }}">
        @if(!empty($youtube))
        <div class="absolute col-12 h-full flex-center z-1">
            <a href="{{ $youtube ?? "" }}" class="d-flex items-center js-gallery" data-gallery="gallery1">
            <span class="button -outline-white text-white size-50 rounded-full flex-center">
              <i class="icon-play text-16"></i>
            </span>
                <span class="fw-500 text-white ml-15">{{ __('Watch Video') }}</span>
            </a>
        </div>
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-7">
                <h2 class="text-30 fw-600">{{ $title ?? '' }}</h2>
                <p class="mt-5">{{ $sub_title ?? '' }}</p>
                <div class="row y-gap-30 pt-60 md:pt-40">
                    @if(!empty($list_item))
                        @foreach($list_item as $k=>$item)
                            <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                            <div class="col-12">
                                <div class="d-flex pr-30">
                                    <img class="size-50" src="{{$image_url}}" alt="{{$item['title']}}">

                                    <div class="ml-15">
                                        <h4 class="text-18 fw-500">{{$item['title']}}</h4>
                                        <p class="text-15 mt-10">{{$item['sub_title']}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
