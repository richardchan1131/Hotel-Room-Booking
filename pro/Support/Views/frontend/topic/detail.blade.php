@extends('Layout::app')
@push('css')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/support/css/support.css?_v='.config('app.asset_version'))}}">
@endpush
@section('content')
    @include('Support::frontend.layouts.topic.search-form')

    <div class="topic-lists-wrap topic-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="page-header">
                        <h1 class="text-24">
                            <i class="fa fa-file-text-o"></i>
                            {{$page_title}}</h1>
                        <div class="ml-3 mt-2 topic-meta">
                            @if($row->cat)
                                @php $cat_trans = $row->cat->translate() @endphp
                                <span class="mr-3">
                                    <i class="fa fa-folder-o mr-1"></i>
                                    <a href="{{$row->cat->getDetailUrl()}}">{{$cat_trans->name ?? ''}}</a>
                                </span>
                            @endif
                            <span>
                                <i class="fa fa-clock-o mr-1"></i> {{display_datetime($row->updated_at ? : $row->created_at)}}
                            </span>
                        </div>
                    </div>
                    <div class="topic-content py-4">
                        {!! clean($translation->content) !!}
                    </div>
                    @if(count($row->tags))
                        <div><strong>{{__("Tags: ")}}</strong>
                            @foreach($row->tags as $index=>$tag)
                                <a href="{{$tag->getDetailUrl()}}">{{$tag->name}}</a> @if($index < count($row->tags) - 1)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <hr>
                    @php $rows = $row->related()->limit(5)->with(['translation','cat'])->get(); @endphp
                    <h4>{{__("Related topics")}}</h4>
                    <div class="topic-lists py-4 list-group">
                        @foreach($rows as $topic)
                            @include('Support::frontend.layouts.topic.loop')
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    @include('Support::frontend.layouts.topic.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
