<section class="layout-pt-md layout-pb-md bg-light-2">
    <div class="container">
        <div class="row y-gap-30">

            @if(!empty($list_item))
                @foreach($list_item as $k => $item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>

                        <div class="col-lg-4 col-md-6">
                            <div class="d-flex pr-30">
                                @if(!empty($image_url))
                                    <img class="size-50" src="{{$image_url}}" alt="{{$item['title'] ?? ''}}">
                                @endif

                                <div class="ml-15">
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
