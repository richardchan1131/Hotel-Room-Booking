<form action="{{url( app_get_locale(false,false,'/').config('event.event_route_prefix') )}}" class="form bravo_form d-flex justify-content-start" id="event_form_search" method="get" onsubmit="return false;">

    @php $event_map_search_fields = setting_item_array('event_map_search_fields');

    $event_map_search_fields = array_values(\Illuminate\Support\Arr::sort($event_map_search_fields, function ($value) {
        return $value['position'] ?? 0;
    }));

    @endphp
    <div class="mainSearch bg-white pr-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 bg-light-2 rounded-4">
        <div class="button-grid items-center" >

        @if(!empty($event_map_search_fields))
            @foreach($event_map_search_fields as $field)
                @switch($field['field'])
                    @case ('location')
                        @include('Event::frontend.layouts.search-map.fields.location')
                    @break
                    @case ('attr')
                        @include('Event::frontend.layouts.search-map.fields.attr')
                    @break
                    @case ('date')
                        @include('Event::frontend.layouts.search-map.fields.date')
                    @break
                @endswitch
            @endforeach
        @endif

            <div class="button-item">
                <button class="mainSearch__submit button -dark-1 size-60 col-12 rounded-4 bg-blue-1 text-white">
                    <i class="icon-search text-20"></i>
                </button>
            </div>
        </div>
    </div>
</form>
