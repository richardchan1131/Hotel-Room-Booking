@php $lang_local = app()->getLocale() @endphp
@php
    $service_translation = $service->translate($lang_local);
    $reviewData = $service->getScoreReview(); $score_total = $reviewData['score_total'];
@endphp
<div class="booking-review">
    <h4 class="booking-review-title">{{__("Your Booking")}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="row x-gap-15 y-gap-20">
                <div class="col-auto">
                    <a href="{{$service->getDetailUrl()}}">
                    @if($image_url = $service->getImageUrl())
                        <img class="size-140 rounded-4 object-cover"  src="{{$image_url}}" alt="{{$service_translation->title}}">
                    @endif
                    </a>
                </div>

                <div class="col">
                    <div class="pb-10">
                        @include('Layout::common.rating',['score_total'=>$score_total])
                    </div>

                    <div class="lh-17 fw-500"><a href="{{$service->getDetailUrl()}}">{{$service_translation->title}}</a></div>
                    @if($service_translation->address)
                        <div class="text-14 lh-15 mt-5">
                            {{$service_translation->address}}
                        </div>
                    @endif

                    <div class="row x-gap-10 y-gap-10 items-center pt-10">
                        <div class="col-auto">
                            @php $vendor = $service->author; @endphp
                            @if($vendor->hasPermission('dashboard_vendor_access') and !$vendor->hasPermission('dashboard_access'))
                                <div class="mt-1">
                                    <i class="icofont-info-circle"></i>
                                    {{ __("Vendor") }}: <a href="{{route('user.profile',['id'=>$vendor->id])}}" target="_blank" >{{$vendor->getDisplayName()}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-section">
            <ul class="review-list">
                @if($booking->start_date)
                    <li>
                        <div class="label">{{__('Start date:')}}</div>
                        <div class="val">
                            {{display_date($booking->start_date)}}
                        </div>
                    </li>
                    @if($booking->getMeta("booking_type") == "ticket")
                        <li>
                            <div class="label">{{__('Duration:')}}</div>
                            <div class="val">
                                @php $duration = $booking->getMeta("duration") @endphp
                                {{duration_format($duration)}}
                            </div>
                        </li>
                    @endif
                    @if($booking->getMeta("booking_type") == "time_slot")
                        <li>
                            <div class="label">{{__('Duration:')}}</div>
                            <div class="val">
                                {{ $booking->getMeta("duration")  }}
                                {{ $booking->getMeta("duration_unit")  }}
                            </div>
                        </li>
                        <li class="flex-wrap">
                            <div class="label w-100 mb-2">{{__('Start Time:')}}</div>
                            <div class="val w-100">
                                <div class="slots-wrapper d-flex justify-content-start flex-wrap">
                                    @if(!empty($timeSlots = $booking->time_slots))
                                        @foreach( $timeSlots as $item )
                                            <div class="btn btn-sm mr-2 mb-2 btn-success">
                                                {{ date( "H:i",strtotime($item->start_time)) }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endif
                @endif
                @if($booking->getMeta("booking_type") == "ticket")
                    @php $ticket_types = $booking->getJsonMeta('ticket_types')@endphp
                    @if(!empty($ticket_types))
                        @foreach($ticket_types as $type)
                            <li>
                                <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}:</div>
                                <div class="val">
                                    {{$type['number']}}
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endif
            </ul>
        </div>
        @do_action('booking.checkout.before_total_review')
        <div class="review-section total-review">
            <ul class="review-list">
                @if($booking->getMeta("booking_type") == "time_slot")
                    <li>
                        <div class="label">{{ $booking->total_guests }} x {{ format_money( $booking->getJsonMeta('base_price')) }}</div>
                        <div class="val">
                            {{format_money( $booking->getJsonMeta('base_price') * $booking->total_guests )  }}
                        </div>
                    </li>
                @endif
                @if($booking->getMeta("booking_type") == "ticket")
                    @php $ticket_types = $booking->getJsonMeta('ticket_types') @endphp
                    @if(!empty($ticket_types))
                        @foreach($ticket_types as $type)
                            <li>
                                <div class="label">{{ $type['name_'.$lang_local] ?? $type['name']}}: {{$type['number']}} * {{format_money($type['price'])}}</div>
                                <div class="val">
                                    {{format_money($type['price'] * $type['number'])}}
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endif
                @php $extra_price = $booking->getJsonMeta('extra_price') @endphp
                @if(!empty($extra_price))
                    <li>
                        <div class="label-title"><strong>{{__("Extra Prices:")}}</strong></div>
                    </li>
                    <li class="no-flex">
                        <ul>
                            @foreach($extra_price as $type)
                                <li>
                                    <div class="label">{{$type['name_'.$lang_local] ?? $type['name']}}:</div>
                                    <div class="val">
                                        {{format_money($type['total'] ?? 0)}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>
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
                                @if(!empty($item['per_ticket']) and $item['per_ticket'] == "on")
                                    : {{$booking->total_guests}} * {{format_money( $fee_price )}}
                                @endif
                            </div>
                            <div class="val">
                                @if(!empty($item['per_ticket']) and $item['per_ticket'] == "on")
                                    {{ format_money( $fee_price * $booking->total_guests ) }}
                                @else
                                    {{ format_money( $fee_price ) }}
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
                <li class="d-block px-20 py-20 bg-blue-2 rounded-4 mt-20">
                    <div class="row y-gap-5 justify-between">
                        <div class="col-auto">
                            <div class="text-18 lh-13 fw-500">{{__("Total:")}}</div>
                        </div>
                        <div class="col-auto">
                            <div class="text-18 lh-13 fw-500">{{format_money($booking->total)}}</div>
                        </div>
                    </div>
                    @if($booking->status !='draft')
                        <div class="row y-gap-5 justify-between">
                            <div class="col-auto">
                                <div class="text-18 lh-13 fw-500">{{__("Paid:")}}</div>
                            </div>
                            <div class="col-auto">
                                <div class="text-18 lh-13 fw-500">{{format_money($booking->paid)}}</div>
                            </div>
                        </div>
                        @if($booking->paid < $booking->total )
                            <div class="row y-gap-5 justify-between">
                                <div class="col-auto">
                                    <div class="text-18 lh-13 fw-500">{{__("Remain:")}}</div>
                                </div>
                                <div class="col-auto">
                                    <div class="text-18 lh-13 fw-500">{{format_money($booking->total - $booking->paid)}}</div>
                                </div>
                            </div>
                        @endif
                    @endif
                </li>
                @include ('Booking::frontend/booking/checkout-deposit-amount')
            </ul>
        </div>
    </div>
</div>
<div class="px-30 py-30 border-light rounded-4 mt-30">
    @includeIf('Coupon::frontend/booking/checkout-coupon')
</div>
