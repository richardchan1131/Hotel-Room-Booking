@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="mb40">
            <div class="d-flex justify-content-between">
                <h1 class="title-bar">{{$group['name']}}</h1>
            </div>
            <hr>
        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <strong>
                            <i class="fa fa-cogs"></i> {{ __("Main Settings") }}</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($groups as $id=>$setting)
                            <a
                                class="list-group-item list-group-item-action @if($current_group == $id) active @endif"
                                href="{{route('core.admin.settings.index',['group'=>$id])}}"
                            >
                                @if(!empty($setting['icon']))
                                    <i class="{{$setting['icon']}}"></i>
                                @endif
                                {{$setting['title']}}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <form action="{{route('core.admin.settings.store',['group'=>$current_group])}}" method="post" autocomplete="off">
                    @csrf

                    @include('Language::admin.navigation')

                    <div class="lang-content-box">
                        @if(empty($group['view']))
                            @include ('Core::admin.settings.groups.'.$current_group)
                        @else
                            @include ($group['view'])
                        @endif
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <span></span>
                        <button class="btn btn-primary" type="submit">{{__('Save settings')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
