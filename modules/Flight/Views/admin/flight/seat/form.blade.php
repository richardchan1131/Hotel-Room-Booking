<div class="col-12">
    <div class="form-group">
        <label for="">{{__('Seat type')}}</label>
        <?php
        $jsons = !empty($row->seatType) ? $row->seatType : false;
        \App\Helpers\AdminForm::select2('seat_type', [
                'configs' => [
                        'ajax'        => [
                                'url' => route('flight.admin.seat_type.getForSelect2'),
                                'dataType' => 'json'
                        ],
                        'allowClear'  => true,
                        'placeholder' => __('-- Select seat type --')
                ]
        ], !empty($jsons->id) ? [
                $jsons->code,
                $jsons->name . ' (#' . $jsons->id  . ')'
        ] : false)
        ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>{{__("Price")}} <span class="text-danger">*</span></label>
        <input type="number" required value="{{$row->price}}" min="1" placeholder="{{__("Price")}}" name="price" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>{{__("Max passengers")}} <span class="text-danger">*</span></label>
        <input type="number" required value="{{$row->max_passengers ?? 1}}" min="1" max="100" placeholder="{{__("Number")}}" name="max_passengers" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>{{__("Person type")}} <span class="text-danger">*</span></label>
        <select name="person" class="form-control" id="">
            <option @if($row->person=='adult') selected @endif value="adult">{{__('Adult')}}</option>
            <option @if($row->person=='child') selected @endif value="child">{{__('Child')}}</option>
        </select>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>{{__("Baggage Check in")}} <span class="text-danger">*</span></label>
        <input type="number" required value="{{$row->baggage_check_in ?? 1}}" min="1" max="100" placeholder="{{__("Number")}}" name="baggage_check_in" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label>{{__("Baggage Cabin")}} <span class="text-danger">*</span></label>
        <input type="number" required value="{{$row->baggage_cabin ?? 1}}" min="1" max="100" placeholder="{{__("Number")}}" name="baggage_cabin" class="form-control">
    </div>
</div>