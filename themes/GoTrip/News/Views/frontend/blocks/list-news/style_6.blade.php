<section class="layout-pt-md layout-pb-lg news-list-block">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row {{$headerAlign}}">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    @if(!empty($desc))
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row y-gap-30 pt-40">

            @php $i = 2; @endphp
            @foreach($rows as $key => $row)

                <div data-anim-child="slide-up delay-" class="col-lg-6 {{$style ?? ''}}">
                    @include('News::frontend.blocks.list-news.loop', ['style' => $style])
                </div>
                @php $i++; if($i == 5) $i = 2; @endphp
            @endforeach
        </div>
    </div>
</section>
