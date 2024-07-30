<section data-anim-wrap class="masthead -type-6">
    @if(!empty($bg_image))
    <div data-anim-child="fade" class="masthead__bg bg-dark-3">
        <img src="{{ get_file_url($bg_image,'full') }}" alt="background">
    </div>
    @endif

    <div class="container">
        <div class="row justify-center">
            <div class="col-xl-9">
                <div class="text-center">
                    <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">{{$title ?? ''}}</h1>
                    <p data-anim-child="slide-up delay-5" class="text-white mt-5">{{ $sub_title ?? '' }}</p>
                </div>

                <div class="g-form-control mt-40">
                    @include('Event::frontend.layouts.search.form-search',['style' => 'normal'])
                </div>
            </div>
        </div>
    </div>
</section>
