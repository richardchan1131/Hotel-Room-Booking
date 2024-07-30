<?php
$passengers = $booking->passengers;
if(!count($passengers)) return;
?>
<div class="b-panel">
    <div class="b-panel-title">{{__("Tickets / Guests Information:")}}</div>
    <div class="b-table-wrap">
        <div class="b-table b-table-div">
            @foreach($passengers as $i=>$passenger)
            <div class="info-first-name b-tr">
                <div class="label">{{__("Guest #:number",['number'=>$i + 1])}}: {{$passenger->first_name}} {{$passenger->last_name}}</div>
                <div class="val text-left" style="text-align: left">
                    {{__("First Name: ")}} <strong>{{$passenger->first_name}}</strong><br>
                    {{__("Last Name: ")}} <strong>{{$passenger->last_name}}</strong><br>
                    {{__("Email: ")}} <strong>{{$passenger->email}}</strong><br>
                    {{__("Phone: ")}} <strong>{{$passenger->phone}}</strong><br>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
