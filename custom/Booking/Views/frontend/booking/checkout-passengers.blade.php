@if($totalPassenger = $booking->calTotalPassenger())
    <?php $old_data = old('passengers', []) ?>
    <div class="form-section mt-40">
        <h3 class="text-22 fw-500 mb-20">{{__("Tickets / Guests Information:")}}</h3>
        <div class="accordion -simple row y-gap-20 pt-30 js-accordion" id="passengers_info">
            @for($i = 1 ; $i <= $totalPassenger ; $i ++)
                <?php $old_item = $old_data[$i] ?? []; ?>
                <div class="col-12 accordion__item px-20 py-20 border-light rounded-4">
                    <div class="accordion__button d-flex items-center" id="passenger_heading_{{$i}}">
                        <div class="accordion__icon size-40 flex-center bg-light-2 rounded-full mr-20">
                            <i class="icon-plus"></i>
                            <i class="icon-minus"></i>
                        </div>
                        <button class="button text-dark-1" data-toggle="collapse" data-target="#passenger_{{$i}}" aria-expanded="true"
                            aria-controls="passenger_{{$i}}">
                            {{__("Guest #:number",['number'=>$i])}}:
                        </button>
                    </div>

                    <div id="passenger_{{$i}}" class="accordion__content @if($i == 1) show @endif"
                         aria-labelledby="passenger_heading_{{$i}}" data-parent="#passengers_info">
                        <div class="pt-20 pl-60">
                            <div class="row y-gap-20">
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <input type="text"  class="form-control"
                                               value="{{$old_item['first_name'] ?? ''}}"
                                               name="passengers[{{$i}}][first_name]">
                                        <label class="lh-1 text-16 text-light-1">{{__("First Name")}} </label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <input type="text"  class="form-control"
                                               value="{{$old_item['last_name'] ?? ''}}"
                                               name="passengers[{{$i}}][last_name]">
                                        <label class="lh-1 text-16 text-light-1">{{__("Last Name")}}</label>

                                    </div>
                                </div>
                                <div class="col-md-6 field-email ">
                                    <div class="form-input">
                                        <input type="email"
                                               class="form-control" value="{{$old_item['email'] ?? ''}}"
                                               name="passengers[{{$i}}][email]">
                                        <label class="lh-1 text-16 text-light-1">{{__("Email")}} </label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-input">
                                        <input type="text"  class="form-control"
                                               value="{{$old_item['phone'] ?? ''}}" name="passengers[{{$i}}][phone]">
                                        <label class="lh-1 text-16 text-light-1">{{__("Phone")}} </label>

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
