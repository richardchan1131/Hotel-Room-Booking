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
                    <div class="page-header d-flex align-items-center justify-content-between">
                        <h1 class="text-24">
                            @if(!empty($cat))
                                <i class="fa fa-folder mr-1"></i>
                            @endif
                            {{$page_title}}</h1>
                        @if(auth()->user()->hasPermission('support_ticket_create'))

                            <a href="{{route('support.ticket.create')}}" class="mb-4 btn btn-info btn-sm">
                                <i class="fa fa-plus"></i> {{__("Ask a question")}}</a>
                        @endif
                    </div>
                    <div class="topic-lists py-4 list-group">
                        <div class="list-group-item list-group-item-light py-3">
                            <div class="topic-item d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <span class="text-16">{{__("Ticket name")}}</span>
                                </div>
                                <div class="mr-3">
                                    <span class="text-16">{{__("Last reply")}}</span>
                                </div>
                                <div>
                                    <span class="text-16">{{__("Status")}}</span>
                                </div>
                            </div>
                        </div>
                        @foreach($rows as $ticket)
                            @include('Support::frontend.layouts.ticket.loop')
                        @endforeach
                    </div>
                    <div class="bravo-pagination">
                        {{$rows->appends(request()->query())->links()}}
                        @if($rows->total() > 0)
                            <span class="count-string">{{ __("Showing :from - :to of :total tickets",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                        @endif
                    </div>
                    @if(!count($rows))
                        <div class="alert alert-warning">{{__("No ticket found")}}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    @include('Support::frontend.layouts.ticket.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
