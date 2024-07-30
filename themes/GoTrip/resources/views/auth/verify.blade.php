@extends('layouts.app')

@section('content')
    <div class="layout-pt-lg layout-pb-lg bg-blue-2 header-margin">
        <div class="container">
            <div class="row justify-content-center bravo-login-form-page bravo-login-page">
                <div class="col-md-8">
                    <div class="card">
                        <div class="bg-green-1 text-white rounded">{{ __('Verify Your Email Address') }}</div>
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif
                            <p>
                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                            </p>
                            <form action="{{ route('verification.send') }}" method="post">
                                @csrf
                                <button class="button px-10 py-10 -dark-1 bg-blue-1 text-white d-inline-flex form-submit mr-10" type="submit">{{ __('click here to request another') }}.</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
