<div class="searchMenu-guests form-select-guests js-form-dd item">

    <div data-x-dd-click="searchMenu-guests">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>

        <div class="text-15 text-light-1 ls-2 lh-16">
            @php
                $adults = request()->query('adults',1);
                $children = request()->query('children',0);
            @endphp
            <div class="render">
                <span class="adults">
                    <span class="one @if($adults >1) d-none @endif">{{__('1 Adult')}}</span>
                    <span class="@if($adults <= 1) d-none @endif multi" data-html="{{__(':count Adults')}}">{{__(':count Adults',['count'=>request()->query('adults',1)])}}</span>
                </span>
                -
                <span class="children">
                    <span class="one @if($children >1) d-none @endif" data-html="{{__(':count Child')}}">{{__(':count Child',['count'=>request()->query('children',0)])}}</span>
                    <span class="multi @if($children <=1) d-none @endif" data-html="{{__(':count Children')}}">{{__(':count Children',['count'=>request()->query('children',0)])}}</span>
                </span>
            </div>
        </div>
    </div>


    <div class="searchMenu-guests__field select-guests-dropdown shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
        <div class="bg-white px-30 py-30 rounded-4">
            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Rooms') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="room"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="room" value="{{request()->query('room',1)}}" min="1">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="room"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <div class="border-top-light mt-24 mb-24"></div>

            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Adults') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="adults"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="adults" value="{{request()->query('adults',1)}}" min="1">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="adults"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>

            <div class="border-top-light mt-24 mb-24"></div>

            <div class="row y-gap-10 justify-between items-center">
                <div class="col-auto">
                    <div class="text-15 fw-500">{{ __('Children') }}</div>
                </div>

                <div class="col-auto">
                    <div class="d-flex items-center">
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-minus" data-input="children"><i class="icon-minus text-12"></i></span>
                        <span class="flex-center size-20 ml-15 mr-15 count-display">
                            <input type="number" name="children" value="{{request()->query('children',0)}}" min="0">
                        </span>
                        <span class="button -outline-blue-1 text-blue-1 size-38 rounded-4 btn-add" data-input="children"><i class="icon-plus text-12"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
