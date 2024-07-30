@extends('layouts.user')

@section('content')
    <h2 class="title-bar">
        {{ __('Payment Settings') }}
    </h2>
    @include('admin.message')
    <form method="POST" action="{{ route('euplatesc.save') }}">
        @csrf
        <div class="booking-history-manager">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">{{ __('EuPlatesc MID') }}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" required name="euplatesc_mid" value="{{ $euplatesc_data->mid ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">{{ __('EuPlatesc Key') }}</label>
                <div class="col-sm-9">
                    <input type="text" required class="form-control" name="euplatesc_key" value="{{ $euplatesc_data->key ?? '' }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">{{ __('Enable EuPlatesc') }}?</label>
                <div class="col-sm-9">
                    <input type="checkbox" class="form-check-input" name="euplatesc_active" value="1" {{ $euplatesc_data?->active ? 'checked' : '' }}>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success ">{{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
@endsection