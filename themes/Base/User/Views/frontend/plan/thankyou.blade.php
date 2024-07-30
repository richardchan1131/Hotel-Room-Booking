@extends('layouts.app')
@section('head')
@endsection
@section('content')
    <section class="pricing-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sec-title text-center">
                        <h2>{{ setting_item_with_lang('user_plans_page_title', app()->getLocale()) ?? __("Pricing Packages")}}</h2>
                        <div class="my-3">
                            @include('admin.message')
                        </div>
                        <p class="text-center">
                            <a class="btn btn btn-primary" href="{{route('user.plan')}}">{{__('My plan')}}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
