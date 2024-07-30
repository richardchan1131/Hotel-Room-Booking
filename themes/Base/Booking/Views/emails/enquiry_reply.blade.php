@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel">
            <h3 class="email-headline"><strong>{{__('Hello :name',['name'=>$enquiry->name])}}</strong></h3>
            <p>{{__('You got reply from vendor. ')}}</p>
            <?php $service = $enquiry->service; ?>
            @if(!empty($service))
                <p><strong>{{__("Service:")}}</strong> <a href="{{$service->getDetailUrl()}}">{{$service->title}}</a></p>
                <p><strong>{{__("Your note:")}}</strong> {{$enquiry->note}}</p>
            @endif
            <p>{{__('Here is the message from vendor:')}}</p>
            <p>{!! clean($enquiry_reply->content) !!}</p>
        </div>
    </div>
@endsection
