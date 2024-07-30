@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{__("Two Factor Authentication")}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto"></div>
    </div>
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
