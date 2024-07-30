<div class="panel">
    <div class="panel-title"><strong>{{__("General")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Coupon Code")}} <span class="text-danger">*</span></label>
                    <input type="text" maxlength="50" required value="{{$row->code}}" placeholder="{{__("Unique Code")}}" name="code" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Coupon Name")}} </label>
                    <input type="text" value="{{$row->name}}" placeholder="{{__("Name")}}" name="name" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Coupon Amount")}} <span class="text-danger">*</span></label>
                    <input type="number" required step="0.1" min="0" value="{{$row->amount}}" placeholder="0" name="amount" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Discount Type")}} </label>
                    <select class="form-control" name="discount_type">
                        <option @if($row->discount_type && $row->discount_type == 'fixed') selected @endif value="fixed">{{__("Amount")}}</option>
                        <option @if($row->discount_type && $row->discount_type == 'percent') selected @endif value="percent">{{__("Percent")}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("End Date")}}</label>
                    <input type="text" value="{{$row->end_date}}" placeholder="{{__("2021-12-12 00:00:00")}}" name="end_date" class="form-control has-datetimepicker">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Usage Restriction")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Minimum Spend")}}</label>
                    <input type="text" value="{{$row->min_total}}" placeholder="{{__("No Minimum")}}" name="min_total" class="form-control">
                    <small>{{ __("The Minimum Spend does not include any Booking fee") }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Maximum Spend")}}</label>
                    <input type="text" value="{{$row->max_total}}" placeholder="{{__("No Maximum")}}" name="max_total" class="form-control">
                    <small>{{ __("The Maximum Spend does not include any Booking fee") }}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Only For Services")}}</label>
                    <?php
                    \App\Helpers\AdminForm::select2('services[]', [
                        'configs' => [
                            'ajax'        => [
                                'url'      => route("coupon.admin.getServices"),
                                'dataType' => 'json'
                            ],
                            'allowClear'  => true,
                            'multiple'    => true,
                            'placeholder' => __('-- Select Services --')
                        ]
                    ], $row->getServicesToArray() , true)
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Only For User")}}</label>
                    <?php
                    \App\Helpers\AdminForm::select2('only_for_user[]', [
                        'configs' => [
                            'ajax'        => [
                                'url'      => route("user.admin.getForSelect2"),
                                'dataType' => 'json'
                            ],
                            'allowClear'  => true,
                            'multiple'    => true,
                            'placeholder' => __('-- Select User --'),
                            'pre_selected' => route('user.admin.getForSelect2', [
                                'type'         => 'car',
                                'pre_selected' => 1
                            ])
                        ]
                    ], $row->getUsersToArray() , true)
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Usage Limits")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Usage Limit per Coupon")}}</label>
                    <input type="number" value="{{$row->quantity_limit}}" placeholder="{{__("Unlimited Usage")}}" name="quantity_limit" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Usage Limit Per User")}}</label>
                    <input type="number" value="{{$row->limit_per_user}}" placeholder="{{__("Unlimited Usage")}}" name="limit_per_user" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
