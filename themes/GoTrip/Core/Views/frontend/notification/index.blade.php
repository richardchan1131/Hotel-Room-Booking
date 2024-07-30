@extends('layouts.app')
@section ('content')
    <link href="{{ asset('dist/frontend/css/notification.css') }}" rel="newest stylesheet">
    <div id="bravo_notify">
        <div class="pt-50 pb-50 bg-light-2 mb-40">
            <div class="text-center">
                <h1 class="text-30 fw-600">{{__('All Notifications')}}</h1>
            </div>
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="col-3">
                    <div class="panel">
                        <ul class="dropdown-list-items p-0">
                            <li class="notification @if(empty($type)) active @endif">
                                <i class="fa fa-inbox fa-lg mr-2"></i> <a href="{{route('core.notification.loadNotify')}}">&nbsp;{{__('All')}}</a>
                            </li>
                            <li class="notification @if(!empty($type) && $type == 'unread') active @endif">
                                <i class="fa fa-envelope-o fa-lg mr-2"></i> <a href="{{route('core.notification.loadNotify', ['type'=>'unread'])}}">{{__('Unread')}}</a>
                            </li>
                            <li class="notification @if(!empty($type) && $type == 'read') active @endif">
                                <i class="fa fa-envelope-open-o fa-lg mr-2"></i> <a href="{{route('core.notification.loadNotify', ['type'=>'read'])}}">{{__('Read')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @include('Core::frontend.notification.list')
            </div>
        </div>
    </div>
    <hr>

@endsection
