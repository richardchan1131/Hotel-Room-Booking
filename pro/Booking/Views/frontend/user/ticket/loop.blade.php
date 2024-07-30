<?php

use Illuminate\Support\Facades\Hash;

?>
<div class="ticket-wrap">
    <div class="ticket-header d-flex justify-content-between">
        <div class="service-info">
            <div class="servive-name">{{$booking->service->title ?? ''}}</div>
            <div class="service-location">
                <i class="fa fa-map-marker"></i> {{$booking->service->address ??''}}</div>
            <div><strong>
                    <i class="fa fa-ticket"></i> {{$ticket->meta['name'] ?? ''}}</strong></div>
        </div>
        <div class="print">
            <button onclick="window.print()" class="btn btn-warning btn-sm">
                <i class="fa fa-print"></i>
            </button>
        </div>
    </div>
    <div class="ticket-body">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%">
                    <div class="label">
                        <i class="fa fa-calendar"></i> {{__("Date")}}</div>
                    <div class="val">{{display_date($booking->start_date)}}</div>
                </td>
                <td>
                    <div class="label">
                        <i class="fa fa-money"></i> {{__("Price")}}</div>
                    <div class="val">{{format_money($ticket->price)}}</div>
                </td>
            </tr>
            <tr>
                <td>
                    @if($booking->getMeta("booking_type") == "ticket")
                        <div class="label">
                            <i class="fa fa-ticket"></i> {{__("Ticket ID")}}: #{{$ticket->id}}</div>
                        <div class="val">
                            {{$ticket->meta['name'] ?? ''}}
                        </div>
                    @endif
                    @if($booking->getMeta("booking_type") == "time_slot")
                        <div class="label">
                            <i class="fa fa-ticket"></i> {{__("Start Time")}}</div>
                        <div class="val">
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
                    @endif
                </td>
                <td>
                    <div class="label">
                        <i class="fa fa-user"></i> {{__("Customer")}}</div>
                    <div class="val">{{$ticket->first_name ?: $booking->first_name}} {{$ticket->last_name ?: $booking->last_name}}
                        <br>
                        {{$ticket->email ?: $booking->email}}
                        <br>
                        {{$ticket->phone ?: $booking->phone}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="ticket-footer">
        @if(!$ticket->is_scanned)
            <div class="text-center">{{__("Show QR Code at the counter")}}</div>
            <div class="qr-content text-center">
                    <?php
                    $dataForHash = ['b' => $booking->id, 't' => $ticket->id];
                    $code = Hash::make($booking->id . '.' . $ticket->id);
                    $url = route('user.booking.ticket.scan', array_merge($dataForHash, ['code' => $code]));
                    ?>
                {!! QrCode::size(200)->generate($url); !!}
            </div>
        @else
            <div class="text-center">
                <span class="badge badge-warning">{{__("QR Code scanned at: :time",['time'=>display_datetime($ticket->scanned_at)])}}</span>
            </div>
        @endif
    </div>
</div>
