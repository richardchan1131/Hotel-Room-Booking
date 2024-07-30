<section class="layout-pt-md layout-pb-lg">
    <div data-anim-wrap class="container">
        @if(!empty($title) || !empty($desc))
            <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ $title }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="row y-gap-30 pt-40 sm:pt-20">
            @php
                $index = 2;
                $classes = 'col-xl-3 col-lg-3';
                if($columns == '3'){
                    $classes = 'col-xl-4 col-lg-4';
                }
            @endphp
            @foreach($rows as $key => $row)
                <div data-anim-child="slide-up delay-{{ $index }}" class="{{ $classes }} col-sm-6">
                    @include('Boat::frontend.layouts.search.loop-grid-2')
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
