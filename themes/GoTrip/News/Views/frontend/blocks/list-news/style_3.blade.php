<section class="layout-pt-md layout-pb-lg">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title }}</h2>
                    @if(!empty($desc))
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc }}</p>
                    @endif
                </div>
            </div>

            @if(!empty($link_title) && !empty($link_more))
                <div class="col-auto">

                    <a href="{{ $link_more }}" class="button -md -blue-1 bg-blue-1-05 text-dark-1">
                        {{ $link_title }} <div class="icon-arrow-top-right ml-15"></div>
                    </a>

                </div>
            @endif
        </div>

        <div class="row y-gap-30 pt-40">

            @php $i = 2; @endphp
            @foreach($rows as $key => $row)

                <div data-anim-child="slide-up delay-{{ $i }}" class="col-lg-4 col-sm-6">

                    @include('News::frontend.blocks.list-news.loop', ['style' => $style])

                </div>
                @php $i++; @endphp
                @if($key == 1)
                    @break
                @endif

            @endforeach

            <div class="col-lg-4">
                <div class="row y-gap-30">
                    @php $i = 2; @endphp
                    @foreach($rows as $key => $row)
                        @php $translation = $row->translate();@endphp
                        @if($key > 1)
                            <div data-anim-child="slide-up delay-{{ $i }}" class="col-lg-12 col-md-6">
                                <a href="{{$row->getDetailUrl()}}" class="blogCard -type-1 d-flex items-center">
                                    <div class="blogCard__image size-130 rounded-8">
                                        @if($row->image_id)
                                            @if(!empty($disable_lazyload))
                                                <img class="object-cover size-130 js-lazy" src="#" data-src="{{get_file_url($row->image_id,'medium')}}" alt="{{$translation->name ?? ''}}">
                                            @else
                                                {!! get_image_tag($row->image_id,'medium',['class'=>'object-cover size-130 js-lazy','alt'=>$row->title]) !!}
                                            @endif
                                        @endif
                                    </div>

                                    <div class="ml-24">
                                        <h4 class="text-18 lh-14 fw-500 text-dark-1">{!! clean($translation->title) !!}</h4>
                                        <p class="text-15">{{ display_date($row->updated_at)}}</p>
                                    </div>
                                </a>
                            </div>
                            @php $i++; @endphp
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
