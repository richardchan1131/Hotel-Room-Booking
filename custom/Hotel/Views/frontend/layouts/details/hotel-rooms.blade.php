@php $review_score = $row->review_data @endphp
<h3 class="text-22 fw-500 heading-section mb-20 pt-40">{{__('Available Rooms')}}</h3>
<div id="hotel-rooms-form" class="hotel_rooms_form border-light rounded-4 shadow-4" v-cloak="" :class="{'d-none':enquiry_type!='book'}">
    <div class="nav-enquiry d-flex" v-if="is_form_enquiry_and_book">
        <div class="enquiry-item active" >
            <span>{{ __("Book") }}</span>
        </div>
        <div class="enquiry-item" data-toggle="modal" data-target="#enquiry_form_modal">
            <span>{{ __("Enquiry") }}</span>
        </div>
    </div>
    <div class="form-book">
        <div class="form-search-rooms">
            <div class="d-flex form-search-row">
                <div class="col-md-4">
                    <div class="form-group form-date-field form-date-search " @click="openStartDate" data-format="{{get_moment_date_format()}}">
                        <i class="fa fa-angle-down arrow"></i>
                        <input type="text" class="start_date" ref="start_date" style="height: 1px; visibility: hidden">
                        <div class="date-wrapper form-content px-20 py-10" >
                            <h4 class="text-15 fw-500 ls-2 lh-16">{{ __('Select Dates') }}</h4>
                            <div class="render check-in-render text-15 text-light-1 ls-2 lh-16" v-html="start_date_html"></div>
                            @if(!empty($row->min_day_before_booking))
                                <div class="render check-in-render">
                                    <small>
                                        @if($row->min_day_before_booking > 1)
                                            - {{ __("Book :number days in advance",["number"=>$row->min_day_before_booking]) }}
                                        @else
                                            - {{ __("Book :number day in advance",["number"=>$row->min_day_before_booking]) }}
                                        @endif
                                    </small>
                                </div>
                            @endif
                            @if(!empty($row->min_day_stays))
                                <div class="render check-in-render">
                                    <small>
                                        @if($row->min_day_stays > 1)
                                            - {{ __("Stay at least :number days",["number"=>$row->min_day_stays]) }}
                                        @else
                                            - {{ __("Stay at least :number day",["number"=>$row->min_day_stays]) }}
                                        @endif
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="searchMenu-guests px-20 py-10 rounded-4 js-form-dd form-group" style="height: 100%; cursor: pointer">
                        <i class="fa fa-angle-down arrow"></i>
                        <div data-x-dd-click="searchMenu-guests">
                            <h4 class="text-15 fw-500 ls-2 lh-16">{{ __('Guest') }}</h4>

                            <div class="text-15 text-light-1 ls-2 lh-16">
                                <span class="js-count-adult">@{{ adults }}</span> {{ __('adults') }}
                                -
                                <span class="js-count-child">@{{ children }}</span> {{ __('children') }}
                            </div>
                        </div>

                        <div class="searchMenu-guests__field shadow-2 mt-1" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                            <div class="bg-white px-30 py-30 rounded-4">
                                <div class="row y-gap-10 justify-between items-center form-guest-search">
                                    <div class="col-auto">
                                        <div class="text-15 fw-500">{{ __('Adults') }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex items-center js-counter" data-value-change=".js-count-adult">
                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down" @click="minusPersonType('adults')">
                                                <i class="icon-minus text-12"></i>
                                            </button>
                                            <span class="input"><input type="number" v-model="adults" min="1"/></span>
                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up" @click="addPersonType('adults')">
                                                <i class="icon-plus text-12"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top-light mt-24 mb-24"></div>

                                <div class="row y-gap-10 justify-between items-center form-guest-search">
                                    <div class="col-auto">
                                        <div class="text-15 lh-12 fw-500">{{ __('Children') }}</div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="d-flex items-center js-counter" data-value-change=".js-count-child">
                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down" @click="minusPersonType('children')">
                                                <i class="icon-minus text-12"></i>
                                            </button>
                                            <span class="input"><input type="number" v-model="children" id="children" min="0"/></span>
                                            <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up" @click="addPersonType('children')">
                                                <i class="icon-plus text-12"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-btn">
                    <div class="g-button-submit bg-blue-1">
                        <button class="btn btn-primary btn-search text-white" @click="checkAvailability" :class="{'loading':onLoadAvailability}" type="submit">
                            {{__("Check Availability")}}
                            <i v-show="onLoadAvailability" class="fa fa-spinner fa-spin"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Hotel::frontend.layouts.details.hotel-room-list')
@include("Booking::frontend.global.enquiry-form",['service_type'=>'hotel'])
