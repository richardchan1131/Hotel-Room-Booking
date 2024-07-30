@extends('Layout::admin.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Booking Core
                <span class="badge badge-warning">PRO</span>
            </div>
            <div class="card-body p-0">
                @include('Pro::admin.upgrade-form')
            </div>
        </div>
    </div>
@endsection
