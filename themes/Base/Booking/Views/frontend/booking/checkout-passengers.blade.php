@if($totalPassenger = $booking->calTotalPassenger())
    <?php $old_data = old('passengers', []) ?>
    <hr>
    <div class="form-section">
        <h4 class="form-section-title">{{__("Tickets / Guests Information:")}}</h4>
        <div class="accordion gateways-table" id="passengers_info">
            @for($i = 1 ; $i <= $totalPassenger ; $i ++)
                <?php $old_item = $old_data[$i] ?? []; ?>
                <div class="card">
                    <div class="card-header c-pointer" id="passenger_heading_{{$i}}">
                        <h4 class="mb-0 " data-toggle="collapse" data-target="#passenger_{{$i}}" aria-expanded="true"
                            aria-controls="passenger_{{$i}}">
                            {{__("Guest #:number",['number'=>$i])}}:
                        </h4>
                    </div>

                    <div id="passenger_{{$i}}" class="collapse @if($i == 1) show @endif"
                         aria-labelledby="passenger_heading_{{$i}}" data-parent="#passengers_info">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("First Name")}} </label>
                                        <input type="text" placeholder="{{__("First Name")}}" class="form-control"
                                               value="{{$old_item['first_name'] ?? ''}}"
                                               name="passengers[{{$i}}][first_name]">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Last Name")}}</label>
                                        <input type="text" placeholder="{{__("Last Name")}}" class="form-control"
                                               value="{{$old_item['last_name'] ?? ''}}"
                                               name="passengers[{{$i}}][last_name]">
                                    </div>
                                </div>
                                <div class="col-md-6 field-email">
                                    <div class="form-group">
                                        <label>{{__("Email")}} </label>
                                        <input type="email" placeholder="{{__("email@domain.com")}}"
                                               class="form-control" value="{{$old_item['email'] ?? ''}}"
                                               name="passengers[{{$i}}][email]">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Phone")}} </label>
                                        <input type="text" placeholder="{{__("Your Phone")}}" class="form-control"
                                               value="{{$old_item['phone'] ?? ''}}" name="passengers[{{$i}}][phone]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endif
