@extends('layouts.app')
@push('css')
    <link href="{{ asset('themes/gotrip/dist/frontend/module/hotel/css/hotel.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endpush
@section('content')
    <div class="bravo_search bravo_search_hotel">
        @if($layout != 'map')
        <section class="pt-40 pb-40 bg-light-2 @if($layout == 'grid') bg-blue-2 @endif">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h1 class="text-30 fw-600">{{setting_item_with_lang("hotel_page_search_title")}}</h1>
                        </div>
                        @include('Hotel::frontend.layouts.search.form-search', ['style' => 'default'])
                    </div>
                </div>
            </div>
        </section>
        @endif

        <section class="layout-pt-md layout-pb-lg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        @include('Hotel::frontend.layouts.search.filter-search')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        @include('Hotel::frontend.layouts.search.list-item', ['layout' => $layout])
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('module/hotel/js/hotel.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
