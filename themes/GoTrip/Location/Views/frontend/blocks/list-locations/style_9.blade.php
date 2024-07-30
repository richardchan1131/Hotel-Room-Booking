<section class="layout-pt-lg layout-pb-md relative {{$layout ?? ''}}" id="secondSection">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>
        <div class="row x-gap-10 y-gap-10 pt-40 sm:pt-20">
            @if($rows)
                @foreach($rows as $k => $row)
                    @php $translation = $row->translate(); @endphp
                    <div data-anim-child="slide-up delay-{{$k+2}}" class="col-xl col-lg-3 col-6">
                        @if(!empty($to_location_detail)) <a href="{{$row->getDetailUrl()}}"> @endif
                            <div class="citiesCard -type-5 d-flex items-center sm:flex-column sm:items-start px-20 py-20 sm:px-15 sm:py-20 bg-light-2 rounded-4">
                                <i class="icon-destination text-24"></i>
                                <div class="ml-10 sm:ml-0 sm:mt-10">
                                    <h4 class="text-16 fw-500">{{ $translation->name }}</h4>
                                </div>
                            </div>
                        @if(!empty($to_location_detail)) </a> @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
