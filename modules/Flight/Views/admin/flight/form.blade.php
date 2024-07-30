
<div class="panel">
    <div class="panel-title"><strong>{{__("Content")}}</strong></div>
    <div class="panel-body">
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>{{__("Name")}}</label>
                    <input type="text" value="{{old("title",$row->title)}}" placeholder="{{__("Name")}}" name="title" class="form-control">
                </div>
                <div class="form-group col-lg-6">
                    <label>{{__("Code")}}</label>
                    <input type="text" value="{{old("code",$row->code)}}" placeholder="{{__("Code")}}" name="code" class="form-control">
                </div>
            </div>
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Airport")}}</strong></div>
    <div class="panel-body">
            <div class="row">
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">{{__('From')}}</label>
                        <?php
                        $jsons = !empty($row->airportFrom) ? $row->airportFrom : false;
                        \App\Helpers\AdminForm::select2('airport_from', [
                                'configs' => [
                                        'ajax'        => [
                                                'url' => route('flight.admin.airport.getForSelect2'),
                                                'dataType' => 'json'
                                        ],
                                        'allowClear'  => true,
                                        'placeholder' => __('-- Select Airport from --')
                                ]
                        ], !empty($jsons->id) ? [
                                $jsons->id,
                                $jsons->name . ' (#' . $jsons->id  . ')'
                        ] : false)
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">{{__('To')}}</label>
                        <?php
                        $jsons = !empty($row->airportTo) ? $row->airportTo : false;
                        \App\Helpers\AdminForm::select2('airport_to', [
                                'configs' => [
                                        'ajax'        => [
                                                'url' => route('flight.admin.airport.getForSelect2'),
                                                'dataType' => 'json'
                                        ],
                                        'allowClear'  => true,
                                        'placeholder' => __('-- Select Airport to --')
                                ]
                        ], !empty($jsons->id) ? [
                                $jsons->id,
                                $jsons->name . ' (#' . $jsons->id  . ')'
                        ] : false)
                        ?>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Airline and time")}}</strong></div>
    <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">{{__('Airline')}}</label>
                        <?php
                        $jsons = !empty($row->airline) ? $row->airline : false;
                        \App\Helpers\AdminForm::select2('airline_id', [
                                'configs' => [
                                        'ajax'        => [
                                                'url' => route('flight.admin.airline.getForSelect2'),
                                                'dataType' => 'json'
                                        ],
                                        'allowClear'  => true,
                                        'placeholder' => __('-- Select Airline --')
                                ]
                        ], !empty($jsons->id) ? [
                                $jsons->id,
                                $jsons->name . ' (#' . $jsons->id  . ')'
                        ] : false)
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Departure time")}}</label>
                        <input type="text" name="departure_time" class="form-control has-datetimepicker" value="{{old("departure_time",$row->departure_time)}}" placeholder="{{__("Departure time")}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Arrival time")}}</label>
                        <input type="text" name="arrival_time" class="form-control has-datetimepicker" value="{{old("arrival_time",$row->arrival_time)}}" placeholder="{{__("Arrival time")}}">
                    </div>
                </div>
                <div class="col-lg-6 d-none">
                    <div class="form-group">
                        <label class="control-label">{{__("Duration")}}</label>
                        <div class="input-group mb-3">
                            <input type="text" name="duration" class="form-control" value="{{old("duration",$row->duration)}}" placeholder="{{__("Duration")}}"  aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">{{__('hours')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>






