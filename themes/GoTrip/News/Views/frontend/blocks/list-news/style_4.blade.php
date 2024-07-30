<section class="layout-pt-lg layout-pb-md">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center {{$headerAlign}}">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title}}</h2>
                    @if(!empty($desc))
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="blog-grid-1 pt-40">
            @php $stt = 2; @endphp
            @foreach($rows as $key => $row)
                @php $translation = $row->translate();@endphp
                <div data-anim-child="slide-up delay-{{$stt}}">
                    @include('News::frontend.blocks.list-news.loop', ['style' => $style,'k' => $key])
                </div>
                @php $stt++; @endphp
            @endforeach

        </div>
    </div>
</section>
