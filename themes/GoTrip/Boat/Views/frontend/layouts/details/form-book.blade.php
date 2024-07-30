<div class="bravo_single_book_wrap d-flex justify-end js-pin-content" data-offset="70">
    <div class="bravo_single_book lg:w-full">
        @include('Layout::common.detail.vendor')
        <div id="bravo_boat_book_app" class="px-30 py-30 rounded-4 border-light bg-white w-360 lg:w-full shadow-4" v-cloak>

            <div class="d-flex justify-between items-center">
                <div class="text-14 text-light-1">
                    <span class="value">
                        <div><span class="text-20 fw-500 text-dark-1">{{ format_money($row->price_per_hour) }}</span><small>{{ __("/per hour") }}</small></div>
                        <div class="lh-1"><span class="text-20 fw-500 text-dark-1">{{ format_money($row->price_per_day) }}</span><small>{{ __("/per day") }}</small></div>
                    </span>
                </div>
                @php $review_score = $row->review_data @endphp
                @if($review_score)
                    <div class="d-flex items-center justify-end">
                        <div class="d-flex items-center">
                            <div class="text-14 text-right mr-10">
                                <div class="lh-15 fw-500">{{$review_score['score_text']}}</div>
                                <div class="lh-15 text-light-1">
                                    @if($review_score['total_review'] > 1)
                                        {{ __(":number reviews",["number"=>$review_score['total_review'] ]) }}
                                    @else
                                        {{ __(":number review",["number"=>$review_score['total_review'] ]) }}
                                    @endif
                                </div>
                            </div>

                            <div class="size-40 flex-center bg-blue-1 rounded-4">
                                <div class="text-14 fw-600 text-white">{{$review_score['score_total']}}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="nav-enquiry mt-20" v-if="is_form_enquiry_and_book">
                <div class="enquiry-item active" >
                    <span>{{ __("Book") }}</span>
                </div>
                <div class="enquiry-item" data-toggle="modal" data-target="#enquiry_form_modal">
                    <span>{{ __("Enquiry") }}</span>
                </div>
            </div>


            <div class="form-book" :class="{'d-none':enquiry_type!='book'}">
                <div class="form-content">
                    <div class="row y-gap-20 pt-20">

                        <!-- Return on same-day -->
                        <div class="col-12">
                            <div class="searchMenu-guests px-20 py-10 border-light rounded-4 js-form-dd">
                                <div data-x-dd-click="searchMenu-guests">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">{{__("Return on same-day")}}</h4>
                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <span class="js-count-adult">@{{ hour }}</span>
                                    </div>
                                </div>
                                <div class="searchMenu-guests__field shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                                    <div class="bg-white px-30 py-30 rounded-4">
                                        <div class="row y-gap-10 justify-between items-center form-guest-search">
                                            <div class="col-auto">
                                                <div class="text-15 fw-500">{{ __("Hours") }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-adult">
                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down" @click="minusHour()">
                                                        <i class="icon-minus text-12"></i>
                                                    </button>
                                                    <span class="input"><input type="number" v-model="hour" min="0"/></span>
                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up" @click="addHour()">
                                                        <i class="icon-plus text-12"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Return on same-day -->

                        <!-- Return on another day -->
                        <div class="col-12">
                            <div class="searchMenu-guests px-20 py-10 border-light rounded-4 js-form-dd">
                                <div data-x-dd-click="searchMenu-guests">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">{{__("Return on another day")}}</h4>
                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <span class="js-count-adult">@{{ day }}</span>
                                    </div>
                                </div>
                                <div class="searchMenu-guests__field shadow-2" data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">
                                    <div class="bg-white px-30 py-30 rounded-4">
                                        <div class="row y-gap-10 justify-between items-center form-guest-search">
                                            <div class="col-auto">
                                                <div class="text-15 fw-500">{{ __("Days") }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="d-flex items-center js-counter" data-value-change=".js-count-adult">
                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down" @click="minusDay()">
                                                        <i class="icon-minus text-12"></i>
                                                    </button>
                                                    <span class="input"><input type="number" v-model="day" min="0"/></span>
                                                    <button class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up" @click="addDay()">
                                                        <i class="icon-plus text-12"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Return on another day -->

                        <!-- Start time -->
                        <div class="col-12">
                            <div class="searchMenu-guests px-20 py-10 border-light rounded-4">
                                <div class="guest-wrapper d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <label>{{__("Start Time")}}</label>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="input-number-group">
                                            <select v-model="start_time" class="form-control" @change="startTimeChange()">
                                                @php $startTime = strtotime( $row->start_time_booking ?? '00:00' );
                                             $endTime = strtotime( $row->end_time_booking ?? '23:30' );  @endphp
                                                @for ( $i = $startTime ; $i <= $endTime ; $i = $i + 1800)
                                                    <option value="{{ date( 'H:i', $i ) }}">{{ date( 'H:i', $i ) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End start time -->

                        <!-- Select Dates -->
                        <div class="col-12">
                            <div class="searchMenu-guests px-20 py-10 border-light rounded-4 form-date-field form-date-search position-relative" data-format="{{get_moment_date_format()}}">
                                <div @click="openStartDate">
                                    <h4 class="text-15 fw-500 ls-2 lh-16">{{__("Start Date")}}</h4>
                                    <div class="text-15 text-light-1 ls-2 lh-16">
                                        <span class="js-start-date" v-html="start_date_html" ></span>
                                    </div>
                                </div>

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
                                <small class="alert-text mt10 mt-2" v-show="message2.content" v-html="message2.content" :class="{'danger':!message2.type,'success':message2.type}"></small>

                            </div>
                            <input type="text" class="start_date" ref="start_date" style="height: 1px;visibility: hidden;position: absolute;left: 0;">
                        </div>
                        <!-- End Select Dates -->

                        <!-- Extra prices -->
                        <div class="col-12">
                            <div class="form-section-group px-20 py-10 border-light rounded-4">
                                <h4 class="form-section-title text-15 fw-500 ls-2 lh-16">{{__('Extra prices:')}}</h4>

                                <div class="form-group " v-for="(type,index) in extra_price">
                                    <div class="extra-price-wrap d-flex justify-content-between">
                                        <div class="flex-grow-1">
                                            <label class="d-flex items-center">
                                                <span class="form-checkbox ">
                                                    <input type="checkbox" true-value="1" false-value="0" v-model="type.enable" style="display: none">
                                                    <span class="form-checkbox__mark">
                                                        <span class="form-checkbox__icon icon-check"></span>
                                                    </span>
                                                </span>
                                                <span class="text-15 ml-10">
                                                    @{{type.name}}
                                                    <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="flex-shrink-0">@{{type.price_html}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End Extra prices -->

                        <!-- Fee -->
                        <div class="col-12" v-if="buyer_fees.length">
                            <div class="form-section-group px-20 py-10 border-light rounded-4">
                                <div class="extra-price-wrap d-flex justify-content-between" v-for="(type,index) in buyer_fees">
                                    <div class="flex-grow-1">
                                        <label>@{{type.type_name}}
                                            <i class="icofont-info-circle" v-if="type.desc" data-toggle="tooltip" data-placement="top" :title="type.type_desc"></i>
                                        </label>
                                        <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="unit" v-if='type.unit == "percent"'>
                                            @{{ type.price }}%
                                        </div>
                                        <div class="unit" v-else >
                                            @{{ formatMoney(type.price) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Fee -->

                        <!-- Total -->
                        <div class="col-12" v-if="total_price > 0">
                            <div class="form-section-group px-20 py-10 border-light rounded-4">
                                <div class="d-flex justify-content-between">
                                    <label>{{__("Total")}}</label>
                                    <span class="price">@{{total_price_html}}</span>
                                </div>
                                <div class="d-flex justify-content-between" v-if="is_deposit_ready">
                                    <label for="">{{__("Pay now")}}</label>
                                    <span class="price">@{{pay_now_price_html}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Total -->

                        <div class="col-12" v-if="html">
                            <div v-html="html"></div>
                        </div>

                        <div class="submit-group">
                            <a class="button -dark-1 py-15 px-35 h-60 col-12 rounded-4 bg-blue-1 text-white cursor-pointer" @click="doSubmit($event)" :class="{'disabled':onSubmit,'btn-success':(step == 2),'btn-primary':step == 1}" name="submit">
                                <span v-if="step == 1">{{__("BOOK NOW")}}</span>
                                <span v-if="step == 2">{{__("Book Now")}}</span>
                                <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                            </a>
                            <div class="alert-text mt-10" v-show="message.content" v-html="message.content" :class="{'danger':!message.type,'success':message.type}"></div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="form-send-enquiry" v-show="enquiry_type=='enquiry'">
                <button class="btn btn-primary" data-toggle="modal" data-target="#enquiry_form_modal">
                    {{ __("Contact Now") }}
                </button>
            </div>
        </div>
    </div>
</div>
@include("Booking::frontend.global.enquiry-form",['service_type'=>'boat'])
