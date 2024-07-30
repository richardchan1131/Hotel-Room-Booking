@if($translation->trip_ideas)
    <section class="layout-pt-md layout-pb-lg">
        <div class="row">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ __("Top sights in  :text",['text'=>$translation->name]) }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ __('These popular destinations have a lot to offer') }}</p>
                </div>
            </div>
        </div>
        <div class="row y-gap-30 pt-40">
            @if(!empty($translation->trip_ideas))
                @php if(!is_array($translation->trip_ideas)) $translation->trip_ideas = json_decode($translation->trip_ideas); @endphp
                @foreach($translation->trip_ideas as $key=>$trip_idea)
                    <div class="col-lg-6">
                        <div class="rounded-4 border-light">
                            <div class="d-flex flex-wrap y-gap-30">
                                <div class="col-auto">
                                    <div class="ratio ratio-1:1 w-200">
                                        @if($trip_idea['image_id'])
                                            {!! get_image_tag($trip_idea['image_id'],'full',['class'=>'img-ratio','lazy'=>false])!!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column justify-center h-full px-30 py-20">
                                        <h3 class="text-18 fw-500">{{$trip_idea['title']}}</h3>
                                        <p class="text-15 mt-5">{{ get_exceprt($trip_idea['content'],80,'...') }}</p>
                                        @if($trip_idea['link'])
                                            <a href="{{$trip_idea['link']}}" class="d-block text-14 text-blue-1 fw-500 underline mt-5">{{ __("See More") }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endif
