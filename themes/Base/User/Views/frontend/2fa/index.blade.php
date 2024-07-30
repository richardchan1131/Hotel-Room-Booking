@extends('layouts.user')
@section('content')
    <h2 class="title-bar">
        {{__("Two Factor Authentication")}}
    </h2>
    @include('admin.message')
    <div class="row">
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-title"><strong>{{__("Setup Two Factor Authentication")}}</strong></div>
                <div class="panel-body">
                    @if(auth()->user()->two_factor_secret)
                        @include('User::frontend.2fa.parts.info')
                    @else
                        @include('User::frontend.2fa.parts.setup')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
