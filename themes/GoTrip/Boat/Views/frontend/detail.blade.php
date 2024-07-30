@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endpush
@section('content')
    <div class="bravo_detail_boat bravo_detail">
        @include('Layout::parts.bc')
        @include('Boat::frontend.layouts.details.title-and-share')

        <section class="pt-40">
            <div class="container js-pin-container">
                <div class="row y-gap-30">
                    <div class="col-lg-8">
                        @include('Boat::frontend.layouts.details.detail')
                    </div>
                    <div class="col-lg-4">
                        @include('Boat::frontend.layouts.details.form-book')
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-40 mb-40">
            <div class="border-top-light"></div>
        </div>

        @if(($row->map_lat && $row->map_lng) || $translation->faqs )
            @if($row->map_lat && $row->map_lng)
                <section class="mt-40">
                    @include('Layout::map.detail.map')
                </section>
            @endif
            <div class="mt-40"></div>

            @if($translation->faqs)
                <section>
                    <div class="container">
                        @include('Layout::common.detail.faq2',['faqs'=>$translation->faqs])
                    </div>
                </section>
            @endif

            <div class="container mt-40 mb-40">
                <div class="border-top-light"></div>
            </div>
        @endif

        <section class="pt-40">
            <div class="container">
                @include('Layout::common.detail.review')
            </div>
        </section>

        <div class="layout-pt-lg"></div>

        <div class="bravo-more-book-mobile">
            <div class="container">
                <div class="left">
                    <div class="g-price">
                        <div class="prefix">
                            <span class="fr_text">{{__("from")}}</span>
                        </div>
                        <div class="price">
                            <span class="onsale">{{ $row->display_sale_price }}</span>
                            <span class="text-price">{{ $row->display_price }}</span>
                        </div>
                    </div>
                    @if(setting_item('boat_enable_review'))
                        <?php
                        $reviewData = $row->getScoreReview();
                        $score_total = $reviewData['score_total'];
                        ?>
                        <div class="service-review tour-review-{{$score_total}}">
                            <div class="list-star">
                                <ul class="booking-item-rating-stars">
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                </ul>
                                <div class="booking-item-rating-stars-active" style="width: {{  $score_total * 2 * 10 ?? 0  }}%">
                                    <ul class="booking-item-rating-stars">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <span class="review">
                        @if($reviewData['total_review'] > 1)
                                    {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                                @else
                                    {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                                @endif
                    </span>
                        </div>
                    @endif
                </div>
                <div class="right">
                    @if($row->getBookingEnquiryType() === "book")
                        <a class="rounded-4 bg-blue-1 text-white cursor-pointer btn-primary gotrip-detail-book-mobile">{{__("Book Now")}}</a>
                    @else
                        <a class="rounded-4 bg-blue-1 text-white cursor-pointer btn-primary" data-bs-toggle="modal" data-bs-target="#enquiry_form_modal">{{__("Contact Now")}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {
                            iconUrl:"{{get_file_url(setting_item("boat_icon_marker_map"),'full') ?? url('images/icons/png/pin.png') }}"
                        }
                    });
                }
            });
            @endif
        })
    </script>
    <script>
        var bravo_booking_data = {!! json_encode($booking_data) !!}
        var bravo_booking_i18n = {
			no_date_select:'{{__('Please select start date')}}',
            no_guest_select:'{{__('Please select at least one number')}}',
            load_dates_url:'{{route('boat.vendor.availability.loadDates')}}',
            availability_booking_url:'{{route('boat.vendor.availability.availabilityBooking')}}',
            name_required:'{{ __("Name is Required") }}',
            email_required:'{{ __("Email is Required") }}',
        };
    </script>
    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
    <script type="text/javascript" src="{{ asset('module/boat/js/single-boat.js?_ver='.config('app.asset_version')) }}"></script>
@endpush
