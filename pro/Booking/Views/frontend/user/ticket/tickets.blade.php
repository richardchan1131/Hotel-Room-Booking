@extends('Booking::frontend.user.ticket.layout')
@section('ticket_content')
    <div id="invoice-print-zone">
        <div class="ticket-content">
            @include('admin.message')
            @foreach($tickets as $k=>$ticket)
                @if($k)
                    <div style="page-break-after: always;">&nbsp</div>
                    <div style="page-break-before: always;">&nbsp;</div>
                @endif
                <div class="mb-3">
                    @include('Booking::frontend.user.ticket.loop')
                </div>
            @endforeach
        </div>
    </div>
@endsection
