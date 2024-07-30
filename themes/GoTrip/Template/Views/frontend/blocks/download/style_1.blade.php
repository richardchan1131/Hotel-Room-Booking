<section data-anim-wrap class="section-bg pt-80 pb-80 md:pt-40 md:pb-40 download-app {{ $style ?? '' }}">
    <div class="container">
        <div class="row y-gap-30 items-center justify-between">
            <div data-anim-child="slide-up delay-2" class="col-xl-5 col-lg-6 col-left">
                <h2 class="text-30 lh-15">{{ $title ?? '' }}</h2>
                <p class="text-dark-1 pr-40 lg:pr-0 mt-15 sm:mt-5">{{ $sub_title ?? '' }}</p>

                @if(!empty($list_item))
                <div class="row y-gap-20 items-center pt-30 sm:pt-10">
                    @foreach($list_item as $item)
                        <div class="col-auto">
                            <div class="d-flex items-center px-20 py-10 rounded-8 border-white-15 text-white bg-dark-3">
                                <div class="{{ $item['icon'] ?? '' }} text-24"></div>
                                <div class="ml-20">
                                    <div class="text-14"><a href="{{ $item['link'] ?? '#' }}" target="_blank">{{ $item['subtitle'] ?? '' }}</a></div>
                                    <div class="text-15 lh-1 fw-500"><a href="{{ $item['link'] ?? '#' }}" target="_blank">{{ $item['title'] ?? '' }}</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div data-anim-child="slide-up delay-3" class="col-lg-6 col-right">
                <img src="{{ $bg_image_url ?? "" }}" alt="image" data-src="{{ $bg_image_url ?? "" }}" class="js-lazy">
            </div>
        </div>
    </div>
</section>
