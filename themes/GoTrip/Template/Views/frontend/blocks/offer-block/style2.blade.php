<div class="bravo-offer layout-pt-lg layout-pb-md">
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
            <div class="row y-gap-20 pt-40">
                @foreach($list_item as $key=>$item)
                    <div data-anim-child="slide-up delay-{{$key+2}}" class="col-lg-4 col-sm-6">
                        <div class="ctaCard -type-1 rounded-4">
                            <div class="ctaCard__image ratio ratio-41:45">
                                <img class="img-ratio js-lazy" src="#" data-src="{{ get_file_url($item['background_image'],'full') ?? "" }}" alt="image">
                            </div>
                            <div class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30">
                                @if(!empty($item['featured_text']))
                                    <h4 class="text-30 lg:text-24 text-white">{{ $item['featured_text'] }}</h4>
                                @endif
                                <h4 class="text-30 lg:text-24 text-white">{!! clean($item['title']) !!}</h4>

                                <div class="d-inline-block mt-30">
                                    <a href="{{$item['link_more']}}" class="button px-48 py-15 -blue-1 -min-180 bg-white text-dark-1">{{$item['link_title']}}</a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>