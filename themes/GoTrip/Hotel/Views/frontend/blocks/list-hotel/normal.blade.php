<section class="layout-pt-md layout-pb-lg bravo-gotrip-list-hotel layout_{{$style_list}}">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{ $desc ?? '' }}</p>
                </div>
            </div>
        </div>
        @if(!empty($locations))
        <div data-anim-child="slide-up delay-2" class="tabs -pills-2 pt-40 js-tabs">
            <div class="tabs__controls row x-gap-15 justify-center js-tabs-controls">
                @foreach($locations as $k=>$location)
                    @php $translation = $location->translate(); @endphp
                    <div class="col-auto">
                        <button class="tabs__button mb-5 text-14 fw-500 px-20 py-10 rounded-4 bg-light-2 js-tabs-button @if($k==0) is-tab-el-active @endif" data-tab-target=".-tab-{{$location->slug}}">{{ $translation->name }}</button>
                    </div>
                @endforeach
            </div>

            <div class="tabs__content pt-40 js-tabs-content">
                @foreach($locations as $k=>$location)
                    <div class="tabs__pane -tab-{{$location->slug}} @if($k==0) is-tab-el-active @endif">
                        <div class="row y-gap-30">
                            @foreach($rows as $row)
                                @if($row->location_id == $location->id)
                                    <div class="col-xl-3 col-lg-3 col-sm-6">
                                        @include('Hotel::frontend.layouts.search.loop-grid')
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="row justify-center pt-40">
                    <div class="col-auto">
                        <a href="{{route('hotel.search')}}" class="button px-40 h-50 -outline-blue-1 text-blue-1">
                            {{ __('View All') }} <div class="icon-arrow-top-right ml-15"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
