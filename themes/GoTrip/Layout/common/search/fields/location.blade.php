<?php $location_name = ""; $location_id = ''; $list_json = [];
$traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json , &$location_name, &$location_id) {
    foreach ($locations as $location) {
        $translate = $location->translate();
        if (Request::query('location_id') == $location->id){
            $location_name = $translate->name;
            $location_id = $location->id;
        }
        $list_json[] = [
            'id' => $location->id,
            'title' => $prefix . ' ' . $translate->name,
        ];
        $traverse($location->children, $prefix . '-');
    }
};
$traverse($list_location ?? $tour_location);
if (empty($inputName)){
    $inputName = 'location_id';
}
$type = $search_style ?? "normal";
?>
@if($type=='autocompletePlace')
    <div class="searchMenu-loc item">
        <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
        <div data-x-dd-click="searchMenu-loc">
            <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>
            <div class="text-15 text-light-1 ls-2 lh-16 g-map-place">
                <input type="text" name="map_place" placeholder="{{__("Where are you going?")}}"  value="{{request()->input('map_place')}}" class="border-0">
                <div class="map d-none" id="map-{{\Illuminate\Support\Str::random(10)}}"></div>
                <input type="hidden" name="map_lat" value="{{request()->input('map_lat')}}">
                <input type="hidden" name="map_lgn" value="{{request()->input('map_lgn')}}">
            </div>
        </div>
    </div>
@else
    <div class="searchMenu-loc js-form-dd js-liverSearch item">
        <span class="clear-loc absolute bottom-0 text-12"><i class="icon-close"></i></span>
        <div data-x-dd-click="searchMenu-loc">
            <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>
            <div class="text-15 text-light-1 ls-2 lh-16  @if( $type == "autocomplete") smart-search  @endif ">
                <input type="hidden" name="{{$inputName}}" class="js-search-get-id child_id" value="{{ $location_id ?? '' }}">
                <input type="text" autocomplete="off" @if( $type == "normal") readonly  @endif class="smart-search-location parent_text js-search js-dd-focus" placeholder="{{__("Where are you going?")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}" data-default="{{ json_encode($list_json) }}">
            </div>
        </div>
        <div class="searchMenu-loc__field shadow-2 js-popup-window @if($type!='normal') d-none @endif " data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
            <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                <div class="y-gap-5 js-results">
                    @foreach($list_json as $location)
                        <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-id="{{ $location['id'] }}">
                            <div class="d-flex align-items-center">
                                <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                <div class="ml-10">
                                    <div class="text-15 lh-12 fw-500 js-search-option-target">{{ $location['title'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
