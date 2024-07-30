@extends('layouts.app')
@section('head')

@endsection
@section('content')
    <section class="pricing-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('admin.message')
                    @include('User::frontend.plan.list')
                </div>
            </div>

        </div>
    </section>
@endsection
@section('footer')
@endsection
