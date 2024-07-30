@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600"> {{__("Change Password")}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto"></div>
    </div>
    <div class="bravo-list-item py-30 px-30 rounded-4 bg-white shadow-3 col-md-6">
        <form action="{{ route("user.change_password.update") }}" method="post">
            @csrf
            <div class="form-group">
                <label>{{__("Current Password")}}</label>
                <input type="password" required name="current-password" placeholder="{{__("Current Password")}}" class="form-control">
            </div>
            <div class="form-group">
                <label>{{__("New Password")}}</label>
                <input type="password" required name="new-password" minlength="8" placeholder="{{__("New Password")}}" class="form-control">
                <p><i>{{__("* Require at least one uppercase, one lowercase letter, one number and one symbol.")}}</i></p>
            </div>
            <div class="form-group">
                <label>{{__("New Password Again")}}</label>
                <input type="password" required name="new-password_confirmation" minlength="8" placeholder="{{__("New Password Again")}}" class="form-control">
            </div>
            @include('admin.message')
            <div class="d-flex justify-content-between mt-3">
                <button class="button h-50 px-24 -dark-1 bg-blue-1 text-white" type="submit"><i class="fa fa-save mr-2"></i> {{__('Change Password')}}</button>
            </div>
        </form>
    </div>
@endsection
@push('js')

@endpush
