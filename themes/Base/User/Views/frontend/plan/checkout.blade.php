@extends('layouts.app')
@push('css')
    <link href="{{ asset('module/booking/css/checkout.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
@endpush
@section('content')
    @php
        $translate = $plan->translate();
        if(request()->query('annual')!=1){
            $price = $plan->price;
            $duration_text = $plan->duration_type_text;
        }else{
            $price = $plan->annual_price;
            $duration_text = __('Year');
        }
            $term_conditions = setting_item('booking_term_conditions');

    @endphp
    <section class="pricing-section bravo-booking-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('admin.message')
                    <div class="sec-title text-center mb-5">
                        <h2>{{ setting_item_with_lang('user_plans_page_title', app()->getLocale()) ?? __("Pricing Packages")}}</h2>
                    </div>
                    <div class="pricing-tabs tabs-box">
                        <form method="post" action="{{route('user.plan.buyProcess',['id'=>$plan->id])}}" class="row">
                            @csrf
                            <input type="hidden" name="annual" value="{{request()->query('annual')}}">
                            <div class="pricing-table col-12">
                                <div class="inner-box">
                                    <div class="title">{{$translate->title}}</div>
                                    <div class="price">{{ format_money($price)}}
                                        @if($price)
                                            <span class="duration">/ {{$duration_text}}</span>
                                        @endif
                                    </div>
                                    <div class="table-content">
                                        {!! clean($translate->content) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-section col-12">
                                @include('Booking::frontend.booking.checkout-payment')
                            </div>
                            <div class="form-actions col-12">
                                <div class="form-group">
                                    <label class="term-conditions-checkbox">
                                        <input type="checkbox" name="term_conditions"> {{__('I have read and accept the')}} <a target="_blank" href="{{get_page_url($term_conditions)}}">{{__('terms and conditions')}}</a>
                                    </label>
                                </div>
                                @if(setting_item("booking_enable_recaptcha"))
                                    <div class="form-group">
                                        {{recaptcha_field('booking')}}
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-danger">{{__('Submit')}} </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
@endsection
