    <div class="py-30 px-30 bg-white rounded-4 base-tr mt-30 {{$wrap_class ?? ''}}" data-x="flight-item-{{$row->id}}" data-x-toggle="shadow-{{$row->id}}">
        <div class="row y-gap-30 justify-between">
            <div class="col">
                <div class="row y-gap-10 items-center">
                    <div class="col-sm-auto">
                        <div class="has-skeleton">
                            <img class="size-40" src="{{$row->airline->image_url}}" alt="{{$row->airline->name}}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row x-gap-20 items-end">
                            <div class="col-auto">
                                <div class="has-skeleton">
                                    <div class="lh-15 fw-500">{{$row->departure_time->format("D M d H:i A")}}</div>
                                    <div class="text-15 lh-15 text-light-1">{{$row->airportFrom->name}}</div>
                                </div>
                            </div>

                            <div class="col text-center">
                                <div class="flightLine">
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="has-skeleton">
                                    <div class="lh-15 fw-500">{{$row->arrival_time->format("D M d H:i A")}}</div>
                                    <div class="text-15 lh-15 text-light-1">{{$row->airportTo->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <div class="text-15 text-light-1 px-20 md:px-0 has-skeleton">{{$row->duration.'h'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-auto">
                <div class="has-skeleton">
                    <div class="d-flex items-center h-full">
                        <div class="pl-30 border-left-light h-full md:d-none"></div>

                        <div>
                            <div class="text-right md:text-left mb-10">
                                <div class="text-18 lh-16 fw-500">{{format_money(@$row->min_price)}}</div>
                                <div class="text-15 lh-16 text-light-1">{{__('avg/person')}}</div>
                            </div>

                            <div class="accordion__button">
                                @if($row->can_book)
                                    <a data-id="{{$row->id}}" href=""  onclick="event.preventDefault()" class="button -dark-1 px-30 h-50 bg-blue-1 text-white btn-choose-flight">{{__("Choose")}} <div class="icon-arrow-top-right ml-15"></div></a>
                                @else
                                    <a  href="#"  class="button -dark-1 px-30 h-50 bg-warning-2 text-white btn-disabled">{{__("Full Book")}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<div class="card w-100 shadow-hover-3 mb-4 d-none" >
    <a href="#" class="d-block mb-0 mx-1 mt-1 p-3" tabindex="0">
        <img class="card-img-top" src="{{$row->airline->image_url}}" alt="{{$row->airline->name}}">
    </a>
    <div class="card-body px-3 pt-0 pb-3 my-0 mx-1">
        <div class="row">
            <div class="col-7">
                <a href="#" class="card-title text-dark font-size-17 font-weight-bold" tabindex="0">{{$row->airportFrom->name}}</a>
            </div>
            <div class="col-5">
                <div class="text-right">
                    <h6 class="font-weight-bold font-size-17 text-gray-3 mb-0">{{format_money(@$row->min_price)}}</h6>
                    <span class="font-weight-normal font-size-12 d-block text-color-1">{{__('avg/person')}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="icofont-airplane font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{__('Take off')}}</span>
                        <span class="font-size-14 text-gray-1">{{$row->departure_time->format("D M d H:i A")}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-bottom pb-3 mb-3">
            <div class="px-3">
                <div class="d-flex mx-1">
                    <i class="d-block rotate-90 icofont-airplane-alt font-size-30 text-primary mr-3"></i>
                    <div class="d-flex flex-column">
                        <span class="font-weight-normal text-gray-5">{{__('Landing')}}</span>
                        <span class="font-size-14 text-gray-1">{{$row->arrival_time->format("D M d H:i A")}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center pl-3 pr-3">
            @if($row->can_book)
                <a @click="openModalBook('{{$row->id}}')" href=""  onclick="event.preventDefault()" class="btn btn-primary text-white btn-choose w-100">{{__("Choose")}}</a>
            @else
                <a  href="#"  class="btn btn-warning btn-disabled">{{__("Full Book")}}</a>
            @endif
        </div>
    </div>
</div>
