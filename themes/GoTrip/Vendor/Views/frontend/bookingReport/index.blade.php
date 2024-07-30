@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{ __("Booking Report") }}</h1>
            <div class="text-15 text-light-1">{{ __("Lorem ipsum dolor sit amet, consectetur.") }}</div>
        </div>
        <div class="col-auto">
            <button class="btn btn-info"  data-toggle="modal" data-target="#filter">{{ __('Advanced Filter') }}</button>
        </div>
    </div>
    @include('admin.message')
    <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
        <div class="tabs -underline-2 js-tabs">
            <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                <?php $status_type = Request::query('status'); ?>
                <div class="col-auto">
                    <a href="{{route("vendor.bookingReport")}}" class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 @if(empty($status_type)) is-tab-el-active @endif">
                        {{__("All Booking")}}
                    </a>
                </div>
                @if(!empty($statues))
                    @foreach($statues as $status)
                        <div class="col-auto">
                            <a href="{{route("vendor.bookingReport",['status'=>$status])}}" class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 @if(!empty($status_type) && $status_type == $status) is-tab-el-active @endif" >
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
                                    <th width="15%">{{__("Payment Detail")}}</th>
                                    <th>{{__("Commission")}}</th>
                                    <th class="a-hidden">{{__("Status")}}</th>
                                    <th>{{__("Action")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookings as $booking)
                                    @include(ucfirst($booking->object_model).'::frontend.bookingReport.loop')
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
    <!-- Modal -->
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <form action="">
                    <input type="hidden" name="status" value="{{ request()->input('status') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __("Advanced Filter") }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __("Customer name") }}</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="{{ __("Customer Name") }}" value="{{ request()->input("customer_name") }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ __("From - To") }}</label>
                            <div id="reportrange">
                                <input type="text" class="form-control" name="date" placeholder="{{ __("From - To") }}" value="{{ request()->input("date") }}">
                                <input type="hidden" name="from" value="{{ date("Y-m-d",strtotime('today')) }}">
                                <input type="hidden" name="to" value="{{ date("Y-m-d",strtotime('today')) }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("Close") }}</button>
                        <button type="submit" class="btn btn-primary">{{ __("Filter") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '#set_paid_btn', function (e) {
            var id = $(this).data('id');
            $.ajax({
                url:bookingCore.url+'/booking/setPaidAmount',
                data:{
                    id: id,
                    remain: $('#modal-paid-'+id+' #set_paid_input').val(),
                },
                dataType:'json',
                type:'post',
                success:function(res){
                    alert(res.message);
                    window.location.reload();
                }
            });
        });
        jQuery(function ($){
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
        })
        jQuery(function ($){
            function cb(start, end) {
                $('#reportrange input[name=date]').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#reportrange input[name=from]').val(start.format('YYYY-MM-DD'));
                $('#reportrange input[name=to]').val(end.format('YYYY-MM-DD'));
            }
            $('#reportrange  input[name=date]').daterangepicker({
                "alwaysShowCalendars": true,
                "opens": "center",
                "showDropdowns": true,
            }, cb).on('apply.daterangepicker', function (ev, picker) {
                $('#reportrange input[name=from]').val(picker.startDate.format('YYYY-MM-DD'));
                $('#reportrange input[name=to]').val(picker.endDate.format('YYYY-MM-DD'));
            });
        })
    </script>
@endpush
