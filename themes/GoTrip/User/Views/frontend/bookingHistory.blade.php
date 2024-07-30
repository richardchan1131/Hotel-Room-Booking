@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{ __("Booking History") }}</h1>
            <div class="text-15 text-light-1">{{ __("Lorem ipsum dolor sit amet, consectetur.") }}</div>
        </div>
        <div class="col-auto"></div>
    </div>
    @include('admin.message')
    <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
        <div class="tabs -underline-2 js-tabs">
            <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                <?php $status_type = Request::query('status'); ?>
                <div class="col-auto">
                    <a href="{{route("user.booking_history")}}" class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 @if(empty($status_type)) is-tab-el-active @endif">
                        {{__("All Booking")}}
                    </a>
                </div>
                @if(!empty($statues))
                    @foreach($statues as $status)
                        <div class="col-auto">
                            <a href="{{route("user.booking_history",['status'=>$status])}}" class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 @if(!empty($status_type) && $status_type == $status) is-tab-el-active @endif" >
                                {{booking_status_to_text($status)}}
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="tabs__content pt-30 js-tabs-content">
                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                    <div class="overflow-scroll scroll-bar-1">
                        @if(!empty($bookings) and $bookings->total() > 0)
                            <table class="table-3 -border-bottom col-12">
                                <thead class="bg-light-2">
                                    <tr>
                                        <th width="2%">{{__("Type")}}</th>
                                        <th>{{__("Title")}}</th>
                                        <th class="a-hidden">{{__("Order Date")}}</th>
                                        <th class="a-hidden">{{__("Execution Time")}}</th>
                                        <th>{{__("Total")}}</th>
                                        <th>{{__("Paid")}}</th>
                                        <th>{{__("Remain")}}</th>
                                        <th class="a-hidden">{{__("Status")}}</th>
                                        <th>{{__("Action")}}</th>
                                    </tr>
                                </thead>
                                <div class="tbody">
                                    @foreach($bookings as $key => $booking)
                                        @include(ucfirst($booking->object_model).'::frontend.bookingHistory.loop', ['key' => $key])
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="bravo-pagination pt-30">
                                {{$bookings->appends(request()->query())->links()}}
                            </div>
                        @else
                            {{__("No Booking History")}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.btn-info-booking').on('click',function (e){
            var btn = $(this);
            $(this).find('.user_id').html(btn.data('id'));
            $(this).find('.modal-body').html('<div class="d-flex justify-content-center">{{__("Loading...")}}</div>');
            var modal = $("#modal_booking_detail");
            $.get(btn.data('ajax'), function (html){
                    modal.find('.modal-body').html(html);
                }
            )
        })
    </script>
@endpush
