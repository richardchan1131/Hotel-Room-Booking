<tr>
    <td>
        @if($service = $booking->service)
            <i class="{{$service->getServiceIconFeatured()}}"></i>
        @endif
        {{$booking->object_model}}
    </td>
    <td>
        @if($service = $booking->service)
            @php
                $translation = $service->translate(app()->getLocale());
            @endphp
            <a target="_blank" href="{{$service->getDetailUrl()}}">
                {{$translation->title}}
            </a>
        @else
            {{__("[Deleted]")}}
        @endif
    </td>
    <td>{{display_date($booking->created_at)}}</td>
    <td class="lh-16">
        {{__("Check in")}} : {{display_date($booking->start_date)}} <br>
        {{__("Duration")}} : {{ $booking->getMeta("duration") ?? "1"  }} {{__("hours")}}
    </td>
    <td class="fw-500">{{format_money($booking->total)}}</td>
    <td>{{format_money($booking->paid)}}</td>
    <td>{{format_money($booking->total - $booking->paid)}}</td>
    <td class="{{$booking->status}}">
{{--        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-yellow-4 text-yellow-3">Pending</span>--}}
        <span class="rounded-100 py-4 px-10 text-center text-14 fw-500">{{$booking->statusName}}</span>
    </td>

    <td>
        <div class="dropdown js-dropdown js-actions-1-active">
            <div class="dropdown__button d-flex items-center rounded-4 text-blue-1 bg-blue-1-05 text-14 px-15 py-5" data-el-toggle=".js-actions-{{ $key + 1 }}-toggle" data-el-toggle-active=".js-actions-{{ $key + 1 }}-active">
                <span class="js-dropdown-title">{{ __("Actions") }}</span>
                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
            </div>

            <div class="toggle-element -dropdown-2 js-click-dropdown js-actions-{{ $key + 1 }}-toggle">
                <div class="text-14 fw-500 js-dropdown-list">
                    @if($service = $booking->service)
                        <div><a href="#" class="d-block js-dropdown-link btn-info-booking" data-ajax="{{route('booking.modal',['booking'=>$booking])}}" data-toggle="modal" data-id="{{$booking->id}}" data-target="#modal_booking_detail">{{ __("Details") }}</a></div>
                    @endif

                    <div><a href="{{route('user.booking.invoice',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking open-new-window" onclick="window.open(this.href); return false;">{{ __("Invoice") }}</a></div>

                    @if($booking->status == 'unpaid')
                        <a href="{{route('booking.checkout',['code'=>$booking->code])}}" class="d-block js-dropdown-link btn-info-booking" onclick="window.location.href = this.getAttribute('href')">
                            {{__("Pay now")}}
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </td>
</tr>
