@extends('layouts.app')
@push('css')
    <style type="text/css">
        .profile-service-tabs .bravo-profile-list-services .container{
            padding: 0;
        }
    </style>
@endpush
@section('content')
<div class="page-profile-content page-template-content">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-3">
                    @include('User::frontend.profile.sidebar')
                </div>
                <div class="col-md-9">
                    <h3 class="profile-name">{{__("Hi, I'm :name",['name'=>$user->getDisplayName()])}}</h3>
                    <div class="profile-bio">{!! $user->bio !!}</div>
                    @include('User::frontend.profile.services')
                    <div class="div" style="margin-top: 40px;">
                        @include('User::frontend.profile.reviews')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
