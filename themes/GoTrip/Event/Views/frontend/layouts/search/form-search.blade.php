@php
    $style = $style ?? 'default';
    $classes = ' form-search-all-service mainSearch bg-white px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 mt-30';
    $button_classes = " -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4";
    if($style == 'sidebar'){
        $classes = ' form-search-sidebar';
        $button_classes = " -dark-1 py-15 col-12 bg-blue-1 h-60 text-white w-100 rounded-4";
    }
    if($style == 'normal'){
        $classes = ' px-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 rounded-100 form-search-all-service mainSearch -w-900 bg-white';
        $button_classes = " -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'normal2'){
        $classes = 'mainSearch bg-white pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 rounded-4 shadow-1';
        $button_classes = " -dark-1 py-15 h-60 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'carousel_v2'){
        $classes = " w-100";
        $button_classes = " -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-yellow-1 text-dark-1";
    }
    if($style == 'map'){
        $classes = " w-100";
        $button_classes = " -dark-1 size-60 col-12 rounded-4 bg-blue-1 text-white";
    }
@endphp
<form action="{{ route("event.search") }}" class="gotrip_form_search bravo_form_search bravo_form form {{ $classes }}" method="get">
    @php $search_style = setting_item('event_location_search_style');
         $event_search_fields = setting_item_array('event_search_fields');
            $event_search_fields = array_values(\Illuminate\Support\Arr::sort($event_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
    @endphp
    @if( !empty(request()->input('_layout')) )
        <input type="hidden" name="_layout" value="{{ request()->input('_layout') }}">
    @endif
    <div class="field-items">
        <div class="row w-100 m-0">
            @if(!empty($event_search_fields))
                @foreach($event_search_fields as $field)
                    <div class="col-lg-{{ $field['size'] ?? "6" }} align-self-center px-30 lg:py-20 lg:px-0">
                        @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                        @switch($field['field'])
                            @case ('service_name') @include('Layout::common.search.fields.service_name') @break
                            @case ('location') @include('Layout::common.search.fields.location') @break
                            @case ('date') @include('Layout::common.search.fields.date') @break
                            @case ('attr') @include('Layout::common.search.fields.attr') @break
                        @endswitch
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="button-item">
        <button class="mainSearch__submit button {{ $button_classes }}" type="submit">
            <i class="icon-search text-20 mr-10"></i>
            <span class="text-search">{{__("Search")}}</span>
        </button>
    </div>
</form>
