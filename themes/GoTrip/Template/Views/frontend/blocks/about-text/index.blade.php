<section class="layout-pt-md bravo-about-text">
    <div class="container">
        <div class="row y-gap-30 justify-between items-center">
            <div class="col-lg-5">
                <h2 class="text-30 fw-600">{{ $title ?? "" }}</h2>
                <p class="mt-5">{{ $desc ?? "" }}</p>
                <p class="text-dark-1 mt-60 lg:mt-40 md:mt-20">
                   {!! $content ?? "" !!}
                </p>
            </div>
            @if($img = get_file_url($bg_image,'full'))
                <div class="col-lg-6">
                    <img src="{{ $img }}" alt="{{ $title ?? "" }}" class="rounded-4">
                </div>
            @endif
        </div>
    </div>
</section>
@if(!empty($list_item))
    <section class="pt-60">
        <div class="container">
            <div class="border-bottom-light pb-40">
                <div class="row y-gap-30 justify-center text-center">
                    @foreach($list_item as $item)
                        <div class="col-xl-3 col-6">
                            <div class="text-40 lg:text-30 lh-13 fw-600">{{ $item['title'] }}</div>
                            <div class="text-14 lh-14 text-light-1 mt-5">{{ $item['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
