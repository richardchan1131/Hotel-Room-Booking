<section class="@if($style == 'style2') layout-pt-xl layout-pb-md @else layout-pt-md layout-pb-lg bravo-featured-item @endif {{$style}}">
    <div data-anim-wrap class="container">
        @if(!empty($title))
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center" style="padding-bottom: 50px">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $sub_title ?? '' }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(!empty($list_item))
            <div class="row @if($style == 'style2') y-gap-40 sm:y-gap-10 @else  y-gap-20 @endif justify-between">
                @foreach($list_item as $k=>$item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                    <div data-anim-child="slide-up delay-{{$k+1}}"
                         class="@if($style == 'style2') col-lg-4 col-sm-6 @else col-lg-3 col-sm-6 @endif">
                        <div
                            class="featureIcon -type-1 @if($style == 'style2')  -hover-shadow px-50 py-50 lg:px-24 lg:py-1 @endif">
                            <div class="d-flex justify-center">
                                <img src="{{$image_url}}" alt="{{$item['title']}}">
                            </div>

                            <div class="text-center mt-30">
                                <h4 class="text-18 fw-500">{{$item['title']}}</h4>
                                <p class="text-15 mt-10">{{$item['sub_title']}}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

