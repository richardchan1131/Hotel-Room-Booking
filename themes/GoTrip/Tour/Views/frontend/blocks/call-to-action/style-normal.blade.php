<section class="section-bg layout-pt-xl layout-pb-xl">
    @if(!empty($bg_image))
    <div data-anim="fade delay-1" class="section-bg__item -mx-20" data-parallax="0.7">
        <div data-parallax-target>
            <img src="{{ get_file_url($bg_image ?? "",'full') }}" alt="{{$title ?? 'image'}}">
        </div>
    </div>
    @endif

    <div class="container">
        <div data-anim="fade delay-3" class="row justify-center text-center">
            <div class="col-auto">
                <div class="text-white mb-10">{{ $title ?? '' }}</div>
                <h2 class="text-40 text-white">{{ $sub_title ?? '' }}</h2>

                <div class="d-inline-block mt-30">
                    <a href="{{$link_more ?? '#'}}" class="button -md -blue-1 bg-white text-dark-1">{{$link_title ?? ''}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@if(!empty($list_item))
<section class="pt-50 pb-40 border-bottom-light">
    <div data-anim="slide-up delay-1" class="container">
        <div class="row justify-center text-center">
            @foreach($list_item as $item)
                <div class="col-xl-3 col-sm-6">
                    <div class="text-40 lh-13 text-dark-1 fw-600">{{ $item['number'] }}</div>
                    <div class="text-14 lh-14 text-light-1 mt-5">{{ $item['title'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
