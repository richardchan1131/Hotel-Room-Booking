<div class="row booking-success-notice">
    <div class="col-lg-8 col-md-8">
        <div class="d-flex align-items-center">
            @if(in_array($booking->status , ['cancelled','unpaid']))
                <img src="{{url('images/ico_warning.svg')}}" alt="Payment Success">
                <div class="notice-success">
                    <p class="line1"><span>{{$booking->first_name}},</span>
                        {{__('Your Booking Order is :name yet!',['name'=>$booking->status_name])}}
                    </p>
                    <p class="line2">{{__('The order detail is saved in the Booking history.')}}</p>
                    @if($note = $gateway->getOption("payment_note"))
                        <div class="line2">{!! clean($note) !!}</div>
                    @endif
                </div>
            @else
                <img src="{{url('images/ico_success.svg')}}" alt="Payment Success">
                <div class="notice-success">
                    <p class="line1"><span>{{$booking->first_name}},</span>
                        {{__('your booking was submitted successfully!')}}
                    </p>
                    <p class="line2">{{__('Booking details has been sent to:')}} <span>{{$booking->email}}</span></p>
                    @if($note = $gateway->getOption("payment_note"))
                        <div class="line2">{!! clean($note) !!}</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <ul class="booking-info-detail">
            <li><span>{{__('Booking Number')}}:</span> {{$booking->id}}</li>
            <li><span>{{__('Booking Date')}}:</span> {{display_date($booking->created_at)}}</li>
            @if(!empty($gateway))
                <li><span>{{__('Payment Method')}}:</span> {{$gateway->name}}</li>
            @endif
            <li><span>{{__('Booking Status')}}:</span> <span class="badge badge-primary badge-{{ $booking->status }}">{{ $booking->status_name }}</span></li>
        </ul>
    </div>
</div>
