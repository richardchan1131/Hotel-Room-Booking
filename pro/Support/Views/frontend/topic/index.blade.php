@extends('Layout::app')
@push('css')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/support/css/support.css?_v='.config('app.asset_version'))}}">
@endpush
@section('content')
    @include('Support::frontend.layouts.topic.search-form')

    <div class="topic-lists-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="page-header">
                        <h1 class="text-24">
                            @if(!empty($cat))
                                <i class="fa fa-folder mr-1"></i>
                            @endif
                            {{$page_title}}</h1>
                    </div>
                    <div class="topic-lists py-4 list-group">
                        @foreach($rows as $topic)
                            @include('Support::frontend.layouts.topic.loop')
                        @endforeach
                    </div>
                    <div class="bravo-pagination">
                        {{$rows->appends(request()->query())->links()}}
                        @if($rows->total() > 0)
                            <span class="count-string">{{ __("Showing :from - :to of :total topics",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                        @endif
                    </div>
                    @if(!count($rows))
                        <div class="alert alert-warning">{{__("No topic found")}}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    @include('Support::frontend.layouts.topic.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
