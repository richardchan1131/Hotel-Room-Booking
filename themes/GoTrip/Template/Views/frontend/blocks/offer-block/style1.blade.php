@php $offer_wrap_class = '';
if (!empty($style)){
    switch ($style){
        case ('style1') : $offer_wrap_class = 'layout-pt-lg layout-pb-md'; break;
        default : $offer_wrap_class = 'layout-pt-md layout-pb-md';
    }
} @endphp
<div class="bravo-offer {{$offer_wrap_class}}">
    <div data-anim-wrap class="container">
        @if(!empty($title))
            <div data-anim-child="slide-up delay-1" class="row justify-center text-center pb-40">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($list_item))
            <div class="row y-gap-20">
                @php $stt = 2; @endphp
                @foreach($list_item as $key=>$item)
                    <div data-anim="slide-up delay-{{$stt}}" class="{{ ($style ?? '' == 'style1') ? 'col-lg-4 col-sm-6' : 'col-md-6' }}">

                        <div class="ctaCard -type-1 rounded-4 @if(empty($item['offer_overLay'])) -no-overlay @endif">
                            <div class="ctaCard__image ratio {{ ($style ?? '' == 'style1') ? 'ratio-41:35' : 'ratio-63:55' }}">
                                <img class="img-ratio js-lazy" src="#" data-src="{{ get_file_url($item['background_image'],'full') ?? "" }}" alt="image">
                            </div>

                            <div class="ctaCard__content {{ ($style ?? '' == 'style1') ? 'py-50 px-50' : 'py-70 px-70' }}  lg:py-30 lg:px-30">

                                @if(!empty($item['featured_text']))
                                    <div class="text-15 fw-500 text-white mb-10">{{ $item['featured_text'] }}</div>
                                @endif
                                <h4 class="{{ $style ?? '' == 'style1' ? 'text-30 xl:text-24' : 'text-40 lg:text-26' }} text-white">{!! clean($item['title']) !!}</h4>

                                <div class="d-inline-block mt-30">
                                    <a href="{{$item['link_more']}}" class="button px-48 py-15 -blue-1 -min-180 bg-white text-dark-1">{{$item['link_title']}}</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    @php $stt++; @endphp
                @endforeach
            </div>
        @endif
    </div>
</div>
