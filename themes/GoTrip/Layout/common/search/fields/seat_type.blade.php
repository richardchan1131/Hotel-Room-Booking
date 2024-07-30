<?php
$minValue = 0;
?>
<div class="searchMenu-guests js-form-dd form-select-seat-type item">
    <div data-x-dd-click="searchMenu-guests" class="overflow-hidden seat-input">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>

        <div class="text-15 text-light-1 ls-2 lh-16">
            @php
                $seatTypeGet = request()->query('seat_type',[]);
            @endphp
            <div class="render text-13">
                @foreach($seatType as $type)
                    <?php
                    $inputRender = 'seat_type_'.$type->code.'_render';
                    $inputValue = $seatTypeGet[$type->code] ?? $minValue;
                    ?>
                    <span class="" id="{{$inputRender}}">
                        <span class="one @if($inputValue > $minValue) d-none @endif">{{__( ':min :name',['min'=>$minValue,'name'=>$type->name])}}</span>
                        <span class="@if($inputValue <= $minValue) d-none @endif multi" data-html="{{__(':count '.$type->name)}}">{{__(':count'.$type->name,['count'=>$inputValue??$minValue])}}</span>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="searchMenu-guests__field select-seat-type-dropdown shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
        <div class="bg-white px-30 py-30 rounded-4">
            @foreach($seatType as $type)
                <?php
                $inputName = 'seat_type_'.$type->code;
                $inputValue = $seatTypeGet[$type->code] ?? $minValue;
                ?>

                <div class="row y-gap-10 justify-between items-center">
                    <div class="col-auto">
                        <div class="text-15 fw-500">{{__('Adults :type',['type'=>$type->name])}}</div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex items-center">
                            <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-minus text-12"></i></span>
                            <span class="flex-center size-20 ml-15 mr-15 count-display">
                                <input id="{{$inputName}}" type="number" name="seat_type[{{$type->code}}]" value="{{$inputValue}}" min="{{$inputValue}}">
                            </span>
                            <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="{{$inputName}}" data-input-attr="id"><i class="icon-plus text-12"></i></span>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>


</div>
