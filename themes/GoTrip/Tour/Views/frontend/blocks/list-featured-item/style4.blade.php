<section class="layout-pt-lg layout-pb-md">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $sub_title ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="row y-gap-40 justify-between pt-40 sm:pt-20">
            @if(!empty($list_item))
                @foreach($list_item as $k => $item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>

                        <div data-anim-child="slide-up delay-{{ ($k + 2) }}" class="col-lg-4 col-sm-6">

                            <div class="featureIcon -type-1 -hover-shadow px-50 py-50 lg:px-24 lg:py-15">
                                <div class="d-flex justify-center">
                                    <img src="{{$image_url}}" alt="{{$item['title'] ?? ''}}">
                                </div>

                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500">{{$item['title'] ?? ''}}</h4>
                                    <p class="text-15 mt-10">{{$item['sub_title'] ?? ''}}</p>
                                </div>
                            </div>

                        </div>

                @endforeach
            @endif

        </div>
    </div>
</section>
