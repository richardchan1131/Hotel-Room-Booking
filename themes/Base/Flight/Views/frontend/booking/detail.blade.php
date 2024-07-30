@php $lang_local = app()->getLocale() @endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="service-info">
                <div>
                    @if($image_url = $service->airline->image_url)
                        @if(!empty($disable_lazyload))
                            <img src="{{$image_url}}" class="img-responsive" alt="{!! clean($service->airline->name) !!}">
                        @else
                            {!! get_image_tag($service->airline->image_id,'medium',['class'=>'img-responsive','alt'=>$service->airline->name]) !!}
                        @endif
                    @endif
                </div>
                <div class="mt-2">
                    <h3 class="service-name">{!! clean($service->airline->name) !!}</h3>
                </div>
                <div class="font-weight-medium  mb-3">
                    <p class="mb-1">
                        {{__(':from to :to',['from'=>$service->airportFrom->name,'to'=>$service->airportTo->name])}}
                    </p>
                    {{__(":duration hrs",['duration'=>$service->duration])}}
                </div>

                <div class="flex-self-start justify-content-between">
                    <div class="flex-self-start">
                        <div class="mr-2">
                            <i class="icofont-airplane font-size-30 text-primary"></i>
                        </div>
                        <div class="text-lh-sm ml-1">
                            <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{$service->departure_time->format('H:i')}}</h6>
                            <span class="font-size-14 font-weight-normal text-gray-1">{{$service->airportFrom->name}}</span>
                        </div>
                    </div>
                    <div class="text-center d-none d-md-block d-lg-none">
                        <div class="mb-1">
                            <h6 class="font-size-14 font-weight-bold text-gray-5 mb-0">{{__(":duration hrs",['duration'=>$service->duration])}}</h6>
                        </div>
                    </div>
                    <div class="flex-self-start">
                        <div class="mr-2">
                            <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary"></i>
                        </div>
                        <div class="text-lh-sm ml-1">
                            <h6 class="font-weight-bold font-size-21 text-gray-5 mb-0">{{$service->arrival_time->format("H:i")}}</h6>
                            <span class="font-size-14 font-weight-normal text-gray-1">{{$service->airportTo->name}}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{ __("Start Date") }}</div>
                        <div class="val">
                            {{display_date($booking->start_date)}}
                        </div>
                    </li>
                    <li>
                        <div class="label">{{ __("Duration") }}</div>
                        <div class="val">{{human_time_diff($booking->end_date,$booking->start_date)}}</div>
                    </li>
                @endif
                @php
                    $flight_seat = $booking->getJsonMeta('flight_seat')@endphp
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{$type['seat_type']['name']}}:</div>
                                <div class="val">
                                    {{$type['number']}}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="review-section total-review">
            <ul class="review-list">
                @php $flight_seat = $booking->getJsonMeta('flight_seat')@endphp
                @php $person_types = $booking->getJsonMeta('person_types') @endphp
                @if(!empty($flight_seat))
                    @foreach($flight_seat as $type)
                        @if(!empty($type['number']))
                            <li>
                                <div class="label">{{ $type['seat_type']['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                                <div class="val">
                                    {{format_money($type['price'] * $type['number'])}}
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div>
                            {{__("Extra Prices:")}}
                        </div>
                    </li>
                    @foreach($extra_price as $type)
                        <li>
                            <div class="label">{{$type['name_'.$lang_local] ?? __($type['name'])}}:</div>
                            <div class="val">
                                {{format_money($type['total'] ?? 0)}}
                            </div>
                        </li>
                    @endforeach
                @endif
                @php
                    $list_all_fee = [];
                    if(!empty($booking->buyer_fees)){
                        $buyer_fees = json_decode($booking->buyer_fees , true);
                        $list_all_fee = $buyer_fees;
                    }
                    if(!empty($vendor_service_fee = $booking->vendor_service_fee)){
                        $list_all_fee = array_merge($list_all_fee , $vendor_service_fee);
                    }
                @endphp
                @if(!empty($list_all_fee))
                    @foreach ($list_all_fee as $item)
                        @php
                            $fee_price = $item['price'];
                            if(!empty($item['unit']) and $item['unit'] == "percent"){
                                $fee_price = ( $booking->total_before_fees / 100 ) * $item['price'];
                            }
                        @endphp
                        <li>
                            <div class="label">
                                {{$item['name_'.$lang_local] ?? $item['name']}}
                                <i class="icofont-info-circle" data-toggle="tooltip" data-placement="top" title="{{ $item['desc_'.$lang_local] ?? $item['desc'] }}"></i>
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_person']) and $item['per_person'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
                @includeIf('Coupon::frontend/booking/checkout-coupon')
                <li class="final-total d-block">
                    <div class="d-flex justify-content-between">
                        <div class="label">{{__("Total:")}}</div>
                        <div class="val">{{format_money($booking->total)}}</div>
                    </div>
                    @if($booking->status !='draft')
                        <div class="d-flex justify-content-between">
                            <div class="label">{{__("Paid:")}}</div>
                            <div class="val">{{format_money($booking->paid)}}</div>
                        </div>
                        @if($booking->paid < $booking->total )
                            <div class="d-flex justify-content-between">
                                <div class="label">{{__("Remain:")}}</div>
                                <div class="val">{{format_money($booking->total - $booking->paid)}}</div>
                            </div>
                        @endif
                    @endif
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>