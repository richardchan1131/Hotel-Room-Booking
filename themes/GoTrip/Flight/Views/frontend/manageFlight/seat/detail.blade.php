@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-20 lg:pb-40 md:pb-20">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{$row->id ? __('Edit: ').$row->title : __('Add new seat')}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto">
            <a class="btn btn-info" href="{{route('flight.vendor.seat.index',['flight_id'=>$currentFlight->id])}}">
                <i class="fa fa-hand-o-right"></i> {{__("Manage Seats")}}
            </a>
        </div>
    </div>
    @include('admin.message')
    <div class="lang-content-box">
        <form novalidate action="{{route('flight.vendor.seat.store',['flight_id'=>$currentFlight->id,'id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" class="needs-validation" method="post">
            @csrf
            <div class="form-add-service">
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a data-bs-toggle="tab" data-bs-target="#nav-tour-content" aria-selected="true" class="active">{{__("1. Seat Content")}}</a>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tour-content">
                        @include('Flight::admin.flight.seat.form')
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="button h-50 px-24 -dark-1 bg-blue-1 text-white" type="submit"><i class="fa fa-save mr-2"></i> {{__('Save Changes')}}</button>
            </div>
        </form>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/condition.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" >
        jQuery(function ($) {
            "use strict"
            $(".btn_submit").on('click',function () {
                $(this).closest("form").submit();
            });
        });
    </script>
@endpush
