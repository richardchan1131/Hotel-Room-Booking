@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/news/css/news.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endpush
@section('content')
    <div class="bravo-news">
        @include('News::frontend.layouts.details.news-breadcrumb')
        @php
            $title_page = setting_item_with_lang("news_page_list_title");
            if(!empty($custom_title_page)){
                $title_page = $custom_title_page;
            }
        @endphp
        @if(!empty($title_page))
        <section data-anim="slide-up delay-1" class="layout-pt-md">
            <div class="container">
                <div class="row justify-center text-center">
                    <div class="col-auto">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title">{{ $title_page }}</h2>
                            <p class=" sectionTitle__text mt-5 sm:mt-0 d-none">Lorem ipsum is placeholder text commonly used in site.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <section data-anim="slide-up delay-2" class="layout-pt-md">
            <div class="container">
                <div class="row y-gap-30 justify-between">
                    <div class="col-xl-8">
                        @if($rows->count() > 0)
                            <div class="list-news">
                                @foreach( $rows as $row)
                                    @include('News::frontend.layouts.details.news-loop')
                                @endforeach
                                <div class="bravo-pagination">
                                    {{$rows->appends(request()->query())->links()}}
                                    <span class="count-string">{{ __("Showing :from - :to of :total posts",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                {{__("Sorry, but nothing matched your search terms. Please try again with some different keywords.")}}
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-3">
                        <div data="slide-up delay-3" class="sidebar -blog">
                            @include('News::frontend.layouts.details.news-sidebar')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
