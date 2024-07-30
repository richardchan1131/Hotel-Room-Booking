@extends('layouts.app')
@push('css')

@endpush
@section('content')
    <div class="bravo_search bravo_search_tour">
        @if($layout == 'normal')
            <section class="pt-40 pb-40 bg-light-2">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <h1 class="text-30 fw-600">{{setting_item_with_lang("tour_page_search_title")}}</h1>
                            </div>
                            @include('Tour::frontend.layouts.search.form-search', ['style' => 'default'])
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="layout-pt-md layout-pb-lg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        @include('Tour::frontend.layouts.search.filter-search')
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        @include('Tour::frontend.layouts.search.list-item', ['layout' => $layout])
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('js/filter.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" src="{{ asset('module/tour/js/tour.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
