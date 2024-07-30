<div class="room-available pt-30 hotel_rooms_form">
    <div class="hotel_list_rooms" :class="{'loading':onLoadAvailability}">
        <div class="row">
            <div class="col-12">
                <div class="start_room_sticky"></div>
                <div class="room-item border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20" :class="{'mt-20':index}" v-for="(room,index) in rooms">
                    <h3 class="text-18 fw-500 mb-15">@{{ room.title }}</h3>
                    <div class="roomGrid">
                        <div class="roomGrid__header">
                            <div>{{ __('Room Type') }}</div>
                            <div>{{ __('Benefits') }}</div>
                            <div>{{ __('Select Rooms') }}</div>
                        </div>
                        <div class="roomGrid__grid">
                            <div>
                                <div class="ratio ratio-1:1" @click="showGallery($event,room.id,room.gallery)">
                                    <img :src="room.image" alt="image" class="img-ratio rounded-4">
                                    <div class="count-gallery" v-if="typeof room.gallery !='undefined' && room.gallery && room.gallery.length > 1">
                                        <i class="fa fa-picture-o"></i>
                                        @{{room.gallery.length}}
                                    </div>
                                </div>

                                <a href="javascript:void(0)" class="d-block text-15 fw-500 underline text-blue-1 mt-15" @click="showGallery($event,room.id,room.gallery)">{{ __('Show Room Information') }}</a>
                                <div class="modal" :id="'modal_room_'+room.id" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">@{{ room.title }}</h5>
                                                <span class="c-pointer" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="input-icon field-icon fa">
                                                            <img src="{{asset('images/ico_close.svg')}}" alt="close">
                                                        </i>
                                                    </span>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fotorama" data-nav="thumbs" data-width="100%" data-auto="false" data-allowfullscreen="true">
                                                    <a v-for="g in room.gallery" :href="g.large"></a>
                                                </div>
                                                <div class="list-attributes">
                                                    <div class="attribute-item" v-for="term in room.terms">
                                                        <h4 class="title">@{{ term.parent.title }}</h4>
                                                        <ul class="d-flex justify-content-between flex-wrap" v-if="term.child">
                                                            <li v-for="term_child in term.child">
                                                                <i class="input-icon field-icon" v-bind:class="term_child.icon" data-toggle="tooltip" data-placement="top" :title="term_child.title"></i>
                                                                @{{ term_child.title }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="roomGrid__content">
                                    <div class="room-type-item">
                                        <div class="room-attribute room-meta d-flex">
                                            <div class="item col-auto" v-if="room.size_html">

                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-ruler-compass-alt"></i>
                                                        <span v-html="room.size_html"></span>
                                                    </div>
                                                    <div class="tooltip__content">{{__('Room Footage')}}</div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.beds_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-hotel"></i>
                                                        <span v-html="room.beds_html"></span>
                                                    </div>
                                                    <div class="tooltip__content">{{__('No. Beds')}}</div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.adults_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon icofont-users-alt-4"></i>
                                                        <span v-html="room.adults_html"></span>
                                                    </div>
                                                    <div class="tooltip__content">{{__('No. Adults')}}</div>
                                                </div>
                                            </div>
                                            <div class="item col-auto" v-if="room.children_html">
                                                <div class="tooltip -top h-50">
                                                    <div class="tooltip__text">
                                                        <i class="input-icon field-icon fa-child fa"></i>
                                                        <span v-html="room.children_html"></span>
                                                    </div>
                                                    <div class="tooltip__content">{{__('No. Children')}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="room-attribute mt-10" v-if="room.term_features">
                                            <div class="d-flex items-center" v-for="term_child in room.term_features">
                                                <i class="input-icon field-icon text-20 mr-10" v-bind:class="term_child.icon"></i>
                                                <div class="text-15">@{{ term_child.title }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="text-center">
                                    <span class="price" v-html="room.price_html"></span>
                                </div>
                                <select v-if="room.number" v-model="room.number_selected" class="custom-select form-select rounded-4 border-light px-15 h-50 text-14">
                                    <option value="0">0</option>
                                    <option v-for="i in (1,room.number)" :value="i">@{{i+' '+ (i > 1 ? i18n.rooms  : i18n.room)}} &nbsp;&nbsp; (@{{formatMoney(i*room.price)}})</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hotel_room_book_status" v-if="total_price">
        <div class="row row_extra_service" v-if="extra_price.length">
            <div class="col-md-12">
                <div class="form-section-group">
                    <label>{{__('Extra prices:')}}</label>
                    <div class="row">
                        <div class="col-md-6 extra-item" v-for="(type,index) in extra_price">
                            <div class="extra-price-wrap d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <label class="d-flex items-center">
                                            <span class="form-checkbox ">
                                                <input type="checkbox" true-value="1" false-value="0" class="has-value" style="display: none;" v-model="type.enable">
                                                <span class="form-checkbox__mark"><span class="form-checkbox__icon icon-check"></span></span>
                                            </span>
                                        <span class="text-15 ml-10" style="line-height: 1">@{{type.name}}</span>
                                        <div class="render" v-if="type.price_type">(@{{type.price_type}})</div>
                                    </label>
                                </div>
                                <div class="flex-shrink-0">@{{type.price_html}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row_total_price">
            <div class="col-md-6" style="border-right: 1px solid #ccc">
                <div class="extra-price-wrap d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <label>
                            {{__("Total Room")}}:
                        </label>
                    </div>
                    <div class="flex-shrink-0">
                        @{{total_rooms}}
                    </div>
                </div>
                <div class="extra-price-wrap d-flex justify-content-between" v-for="(type,index) in buyer_fees">
                    <div class="flex-grow-1">
                        <label>
                            @{{type.type_name}}
                            <span class="render" v-if="type.price_type">(@{{type.price_type}})</span>
                            <div class="tooltip -top d-inline-block" v-if="type.desc">
                                <div class="tooltip__text"><i class="input-icon field-icon icofont-info-circle"></i></div>
                                <div class="tooltip__content" style="width: 230px; left: 50%; transform: translateX(-50%);">@{{ type.type_desc }}</div>
                            </div>
                        </label>
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
            <div class="col-md-6">
                <div class="control-book text-right">
                    <div class="total-room-price">
                        <span> {{__("Total Price")}}:</span> @{{total_price_html}}
                    </div>
                    <div v-if="is_deposit_ready" class="total-room-price font-weight-bold">
                        <span>{{__("Pay now")}}</span>
                        @{{pay_now_price_html}}
                    </div>
                    <button type="button" class="button -dark-1 py-15 px-35 rounded-4 bg-blue-1 text-white cursor-pointer d-inline-block" @click="doSubmit($event)" :class="{'disabled':onSubmit}" name="submit">
                        <span >{{__("Book Now")}}</span>
                        <i v-show="onSubmit" class="fa fa-spinner fa-spin"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="end_room_sticky"></div>
    <div class="alert alert-warning" v-if="!firstLoad && !rooms.length">
        {{__("No room available with your selected date. Please change your search critical")}}
    </div>
</div>
