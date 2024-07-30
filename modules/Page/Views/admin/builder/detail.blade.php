@extends('Layout::admin.empty')
@push('css')
    <link rel="stylesheet" href="{{asset('libs/grapesjs/dist/css/grapes.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/admin/module/page/css/builder.css?_v='.config('app.version'))}}">
    <script src="{{asset('libs/grapesjs/dist/grapes.min.js')}}"></script>
@endpush

@section('content')
    <div class="panel__top">
        <div class="panel__basic-actions"></div>
    </div>
    <div id="gjs">
    </div>
    <div id="blocks"></div>
@endsection
@push('js')
    <script src="{{asset('module/page/admin/js/builder.js?_v='.config('app.version'))}}"></script>
@endpush
