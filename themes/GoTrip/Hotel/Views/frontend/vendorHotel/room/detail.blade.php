@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-20 lg:pb-40 md:pb-20">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600"> {{$row->id ? __('Edit: ').$row->title : __('Add new room')}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto">
            <a class="btn btn-info" href="{{route('hotel.vendor.room.index',['hotel_id'=>$hotel->id])}}">
                <i class="fa fa-hand-o-right"></i> {{__("Manage Rooms")}}
            </a>
        </div>
    </div>
    @include('admin.message')
    <div class="mb-2">
        @if($row->id)
            @include('Language::admin.navigation')
        @endif
    </div>
    <div class="lang-content-box">
        <form novalidate action="{{route('hotel.vendor.room.store',['hotel_id'=>$hotel->id,'id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" class="needs-validation" method="post">
            @csrf
            <div class="form-add-service">
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a data-bs-toggle="tab" data-bs-target="#nav-tour-content" aria-selected="true" class="active">{{__("1. Room Content")}}</a>
                    @if(is_default_lang())
                        <a data-bs-toggle="tab" data-bs-target="#nav-tour-pricing" aria-selected="false">{{__("2. Pricing")}}</a>
                        <a data-bs-toggle="tab" data-bs-target="#nav-attribute" aria-selected="false">{{__("3. Attributes")}}</a>
                        <a data-bs-toggle="tab" data-bs-target="#nav-ical" aria-selected="false">{{__("4. Ical")}}</a>

                    @endif
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tour-content">
                        @include('Hotel::admin.room.form-detail.content')
                    </div>
                    @if(is_default_lang())
                        <div class="tab-pane fade" id="nav-tour-pricing">
                            @include('Hotel::admin.room.form-detail.pricing')
                        </div>
                        <div class="tab-pane fade" id="nav-attribute">
                            @include('Hotel::admin.room.form-detail.attributes')
                        </div>
                        <div class="tab-pane fade" id="nav-ical">
                            @include('Hotel::admin.room.form-detail.ical')
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary btn_submit" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
            </div>
        </form>
    </div>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/condition.js?_ver='.config('app.asset_version')) }}"></script>
    <script type="text/javascript" >
        jQuery(function ($) {
            $(".btn_submit").click(function () {
                $(this).closest("form").submit();
            });
        });
    </script>
@endpush

