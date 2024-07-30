@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/boat/css/boat.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
@endpush
@section('content')
    <div class="header-margin"></div>

    @if($layout != 'grid')
        <section class="pt-40 pb-40 bg-light-2">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h1 class="text-30 fw-600">{{ setting_item_with_lang("boat_page_search_title") }}</h1>
                        </div>

                        @include('Boat::frontend.layouts.search.form-search', ['style' => 'default'])
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    @if(!is_mobile())
                        @include('Boat::frontend.layouts.search.sidebar-form-search')
                    @endif
                </div>
                <div class="col-xl-9 col-lg-8">
                    @include('Boat::frontend.layouts.search.list-item', ['layout' => $layout])
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('module/boat/js/boat.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
