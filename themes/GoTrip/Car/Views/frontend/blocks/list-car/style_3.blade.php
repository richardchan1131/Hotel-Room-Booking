<section class="layout-pt-md layout-pb-md bravo-list-event">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row  y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('car.search') }}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                    {{ __('More') }}
                    <div class="icon-arrow-top-right ml-15"></div>
                </a>

            </div>
        </div>
        <div class="row y-gap-30 pt-40 sm:pt-20">
            @php
                $index = 2;
            @endphp
            @foreach($rows as $key => $row)
                <div data-anim-child="slide-up delay-{{ $index }}" class="col-xl-3 col-lg-3 col-sm-6">
                    @include('Car::frontend.layouts.search.loop-grid')
                </div>
                @php
                    $index++;
                    if($key == 5){
                        $index = 2;
                    }
                @endphp
            @endforeach
        </div>
    </div>
</section>