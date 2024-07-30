@extends('Layout::app')
@push('css')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/support/css/support.css?_v='.config('app.asset_version'))}}">
@endpush
@section('content')
    @include('Support::frontend.layouts.topic.search-form')

    <div class="topic-by-category py-4">
        <div class="container">
            <div class="topic-category-list">
                <div class="row">
                    @foreach($cats as $cat)
                            <?php $tran = $cat->translate() ?>
                        <div class="col-md-4 mb-5">
                            <div class="category-item h-100 p-4">
                                <div class="d-flex justify-content-between">
                                    <h3 class="cat-name text-20 font-weight-bold mb-3">
                                        <a href="{{$cat->getDetailUrl()}}">
                                            <i class="fa fa-folder mr-2"></i> {{$tran->name}}</a>
                                    </h3>
                                </div>
                                <div class="topic-list pl-3">
                                    @foreach($cat->latestTopics(4) as $topic)
                                            <?php $topic_trans = $topic->translate() ?>
                                        <div class="topic-item mb-2 text-16">
                                            <a href="{{$topic->getDetailUrl()}}">
                                                <i class="fa fa-file-text-o mr-2"></i> {{$topic_trans->title}}</a>
                                        </div>
                                    @endforeach
                                    <a class="view-all" href="{{$cat->getDetailUrl()}}">{{__("View all")}}
                                        <i class="fa fa-long-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
