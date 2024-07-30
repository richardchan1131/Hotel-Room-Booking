@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel">
            @if($reply->user_id == $ticket->customer_id)
                <h1>{{__("Hello")}} {{$ticket->customer->display_name ?? ''}}</h1>
            @else
                <h1>{{__("Hello")}} {{$ticket->agent->display_name ?? ''}}</h1>
            @endif
            <p>{{__('You got new reply for ticket: #')}}{{$ticket->id}} - {{$ticket->title}}</p>
            <p>{{__("Reply content:")}}</p>
            <p>{!! nl2br(clean($reply->content)) !!}</p>
            <p>{{__('You can check the ticket here:')}}
                <a href="{{route('support.ticket.detail',['id'=>$ticket->id])}}">{{__('View ticket')}}</a>
            </p>
            <br>
            <p>{{__('Regards')}},
                <br>{{setting_item('site_title')}}</p>
        </div>
    </div>
@endsection
