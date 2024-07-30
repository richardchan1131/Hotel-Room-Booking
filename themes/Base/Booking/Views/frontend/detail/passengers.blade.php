<?php
$passengers = $booking->passengers;
if(!count($passengers)) return;
?>
<h4 class="form-section-title">{{__("Tickets / Guests Information:")}}</h4>
<div class="accordion gateways-table my-3" id="passengers_info">
    @foreach($passengers as $i=>$passenger)
        <div class="card">
            <div class="card-header c-pointer" id="passenger_heading_{{$i + 1}}">
                <h4 class="mb-0 " style="font-size: 16px" data-toggle="collapse" data-target="#passenger_{{$i + 1}}" aria-expanded="true"
                    aria-controls="passenger_{{$i + 1}}">
                    {{__("Guest #:number",['number'=>$i + 1])}}: {{$passenger->first_name}} {{$passenger->last_name}}
                </h4>
            </div>

            <div id="passenger_{{$i + 1}}" class="collapse @if($i + 1 == 1) show @endif"
                 aria-labelledby="passenger_heading_{{$i + 1}}" data-parent="#passengers_info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__("First Name")}}: </label>
                                <strong> {{$passenger->first_name}}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__("Last Name")}}:</label>

                                <strong>{{$passenger->last_name}}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 field-email">
                            <div class="form-group">
                                <label>{{__("Email")}}: </label>
                                <strong>
                                {{$passenger->email}}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__("Phone")}}: </label>

                                <strong>{{$passenger->phone}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
