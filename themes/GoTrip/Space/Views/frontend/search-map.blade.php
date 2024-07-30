@extends('layouts.app',['container_class'=>'container-fluid','header_right_menu'=>true])
@push('css')
    <link href="{{ asset('themes/gotrip/dist/frontend/module/space/css/space.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <style type="text/css">
        .bravo_topbar, .footer {
            display: none
        }
    </style>
@endpush
@section('content')
    @php $disable_subscribe_default = true @endphp
    <section class="bravo_search bravo_search_space halfMap">
        <h1 class="d-none">
            {{setting_item_with_lang("space_page_search_title")}}
        </h1>
        <div class="halfMap__content">
            <div class="bravo_form_search_map">
                <div class="mainSearch bg-white pr-10 py-10 lg:px-20 lg:pt-5 lg:pb-20 bg-light-2 rounded-4">
                    @include('Space::frontend.layouts.search.form-search', ['style' => 'map'])
                </div>
            </div>
            <div class="bravo_filter_search_map" id="advance_filters">
                @include('Space::frontend.layouts.search-map.filter-search-map')
            </div>

            <div class="row y-gap-10 justify-between items-center pt-20">
                <div class="col-auto">
                    <div class="text-18 fw-500 result-count">
                        @if($rows->total() > 1)
                            {{ __(":count boats found",['count'=>$rows->total()]) }}
                        @else
                            {{ __(":count boat found",['count'=>$rows->total()]) }}
                        @endif
                    </div>
                </div>
                <div class="col-auto bc-form-order">
                    @include('Layout::global.search.orderby',['routeName'=>'boat.search','hidden_map_button'=>1])
                </div>
            </div>
            <div class="ajax-search-result">
                @include('Space::frontend.ajax.search-result-map', ["layout" => "normal"])
            </div>
        </div>

        <div class="halfMap__map position-relative">
            <div class="results_map">
                <div class="map-loading d-none">
                    <div class="st-loader"></div>
                </div>
                <div id="bravo_results_map" class="results_map_inner"></div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        var bravo_map_data = {
            markers:{!! json_encode($markers) !!},
            map_lat_default:{{setting_item('space_map_lat_default','0')}},
            map_lng_default:{{setting_item('space_map_lng_default','0')}},
            map_zoom_default:{{setting_item('space_map_zoom_default','6')}},
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('themes/gotrip/dist/frontend/js/filter-map.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
