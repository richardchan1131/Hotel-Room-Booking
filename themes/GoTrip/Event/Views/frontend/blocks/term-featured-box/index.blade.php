<section class="layout-pt-md layout-pb-md">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="row y-gap-30 pt-40 sm:pt-20">
            @if($list_term)
                @foreach($list_term as $term)
                    @php $translation = $term->translate(); @endphp
                    <div class="col-xl col-md-4 col-sm-6">

                        <a href="{{ route('event.search',['terms[]' => $term->id]) }}" class="tourTypeCard -type-1 d-block rounded-4 bg-white border-light rounded-4">
                            <div class="tourTypeCard__content text-center pt-60 pb-24 px-30">
                                @if(!empty($term->icon))
                                    <i class="{{$term->icon}} text-60 sm:text-40 text-blue-1"></i>
                                @endif
                                <h4 class="text-dark-1 text-18 fw-500 mt-50 md:mt-30">{{ $translation->name ?? '' }}</h4>
                                <p class="text-light-1 lh-14 text-14 mt-5">
                                    @if($term->event->count() > 1)
                                        {{ __(':number Events',['number' => $term->event->count()]) }}
                                    @else
                                        {{ __(':number Event',['number' => $term->event->count()]) }}
                                    @endif
                                </p>
                            </div>
                        </a>

                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
