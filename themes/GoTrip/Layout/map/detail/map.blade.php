@if(!empty($row->location->name))
    <section class="pb-40">
        @php $location =  $row->location->translate() @endphp
        <div class="{{ $class_container ?? "container" }}">
            <h3 class="text-22 fw-500 mb-10">{{ __('Where you’ll be') }}</h3>
            <div class="mb-20">{{$location->name ?? ''}}</div>
            @if($row->map_lat && $row->map_lng)
                <div class="g-location">
                    <div class="location-map">
                        <div id="map_content" class="map rounded-4 map-500"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
