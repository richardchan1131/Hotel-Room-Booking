<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab"
            href="#booking-detail-{{ $booking->id }}">{{ __('Booking Detail') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#booking-customer-{{ $booking->id }}">
            @if (!empty($informationRole))
                {{ __('Customer Information') }}
            @else
                {{ __('Personal Information') }}
            @endif
        </a>
    </li>
    @if (count($booking->passengers))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#booking-guests-{{ $booking->id }}">
                {{ __('Guests Information') }}
            </a>
        </li>
    @endif
</ul>
<div class="tab-content">
    <div id="booking-detail-{{ $booking->id }}" class="tab-pane active">
        <div class="booking-review">
            <div class="booking-review-content">
                <div class="review-section">
                    <div class="info-form">
                        <ul>
                            <li>
                                <div class="label">{{ __('Booking Status') }}</div>
                                <div class="val">{{ $booking->statusName }}</div>
                            </li>
                            <li>
                                <div class="label">{{ __('Booking Date') }}</div>
                                <div class="val">{{ display_date($booking->created_at) }}</div>
                            </li>
                            @if (!empty($booking->gateway))
                                <?php $gateway = get_payment_gateway_obj($booking->gateway); ?>
                                @if ($gateway)
                                    <li>
                                        <div class="label">{{ __('Payment Method') }}</div>
                                        <div class="val">{{ $gateway->name }}</div>
                                    </li>
                                @endif
                            @endif
                            @php $vendor = $service->author; @endphp
                            @if ($vendor->hasPermission('dashboard_vendor_access') and !$vendor->hasPermission('dashboard_access'))
                                <li>
                                    <div class="label">{{ __('Vendor') }}</div>
                                    <div class="val"><a href="{{ route('user.profile', ['id' => $vendor->id]) }}"
                                            target="_blank">{{ $vendor->getDisplayName() }}</a></div>
                                </li>
                            @endif
                            @if ($booking->additional_details)
                                @php
                                    $additional = json_decode($booking->additional_details);
                                @endphp
                                @if (isset($additional->meals))
                                    @foreach ($additional->meals as $meal)
                                        <li>
                                            <div class="label">{{ __('Meals') }}</div>
                                            <div class="val">{{ $meal }}</div>
                                        </li>
                                    @endforeach
                                @endif
                                @if (isset($additional->additional_bed) && ($additional->additional_bed != 'false'))
                                    <li>
                                        <div class="label">{{ __('Supplymentary bed') }}</div>
                                        <div class="val">{{ __('Yes') }}</div>
                                    </li>
                                @endif
                                @if (isset($additional->freecancelation))
                                    <li>
                                        <div class="label">{{ __('Free cancelation') }}</div>
                                        <div class="val">{{ __('Yes') }}</div>
                                    </li>
                                @endif

                                @if (isset($additional->children))
                                    @foreach ($additional->children as $children)
                                        <li>
                                            <div class="label">{{ __('Children') }}</div>
                                            <div class="val">{{ $children }} {{ __('years old') }}</div>
                                        </li>
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="more-booking-review">
            @include ($service->checkout_booking_detail_file ?? '')
        </div>
    </div>
    <div id="booking-customer-{{ $booking->id }}" class="tab-pane fade">
        @include ($service->booking_customer_info_file ?? 'Booking::frontend/booking/booking-customer-info')
    </div>
    <div id="booking-guests-{{ $booking->id }}" class="tab-pane fade">
        @include ('Booking::frontend.detail.passengers')
    </div>
</div>
