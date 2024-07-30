@extends('layouts.user')
@section('content')
    <div class="bravo-user-dashboard">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">{{ __("Dashboard") }}</h1>
                <div class="text-15 text-light-1">{{ __("Ready to jump back in?") }}</div>
            </div>
            <div class="col-auto">
            </div>
        </div>

        @include('admin.message')

        <div class="row y-gap-30">
            @if(!empty($cards_report))
                @foreach($cards_report as $key => $item)
                    <div class="col-xl-3 col-md-6">
                        <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="fw-500 lh-14">{{ $item['title'] }}</div>
                                    <div class="text-26 lh-16 fw-600 mt-5">{{ $item['amount'] }}</div>
                                    <div class="text-15 lh-14 text-light-1 mt-5">{{ $item['desc'] }}</div>
                                </div>

                                <div class="col-auto">
                                    <img src="{{ asset('/themes/gotrip/images/user/dashboard/'. ($key + 1) . '.svg') }}" alt="icon">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row y-gap-30 pt-20">
            <div class="col-xl-7 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="d-flex justify-between items-center">
                        <h2 class="text-18 lh-1 fw-500">
                            {{ __("Earning Statistics") }}
                        </h2>
                        <div class="action-control d-flex items-center bg-white border-light rounded-100 px-15 py-10 text-14 lh-12">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pt-30">
                        <canvas class="bravo-user-render-chart"></canvas>
                        <script>
                            var earning_chart_data = {!! json_encode($earning_chart_data) !!};
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="d-flex justify-between items-center">
                        <h2 class="text-18 lh-1 fw-500">
                            {{ __("Recent Bookings") }}
                        </h2>

                        <div class="">
                            <a href="{{ route('vendor.bookingReport') }}" class="text-14 text-blue-1 fw-500 underline">{{ __("View All") }}</a>
                        </div>
                    </div>

                    <div class="overflow-scroll scroll-bar-1 pt-30">
                        <table class="table-2 col-12">
                            <thead class="">
                            <tr>
                                <th>#</th>
                                <th>{{ __("Item") }}</th>
                                <th>{{ __("Total") }}</th>
                                <th>{{ __("Paid") }}</th>
                                <th>{{ __("Status") }}</th>
                                <th>{{ __("Created At") }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if($recent_bookings)
                                @foreach($recent_bookings as $val)
                                    <tr>
                                        <td>#{{ $val->id }}</td>
                                        <td>{{ $val->service->title ?? '' }}</td>
                                        <td class="fw-500">{{ format_money($val->total) }}</td>
                                        <td>{{ format_money($val->paid) }}</td>
                                        <td>
                                            @php
                                                switch ($val->status){
                                                    case "unpaid":
                                                    case "processing":
                                                    case "pending":
                                                        $status_class = 'bg-yellow-4 text-yellow-3';
                                                        break;
                                                    case "partial_payment":
                                                        $status_class = 'bg-blue-1-05 text-blue-1';
                                                        break;
                                                    case "paid":
                                                    case "completed":
                                                    case "confirmed":
                                                        $status_class = 'bg-green-1 text-green-2';
                                                        break;
                                                    case "cancelled":
                                                    case "cancel":
                                                        $status_class = 'bg-border text-black';
                                                        break;
                                                    case "fail":
                                                        $status_class = 'bg-red-3 text-red-2';
                                                        break;
                                                    default:
                                                        $status_class = 'bg-light-2 text-light-1';
                                                        break;
                                                }
                                            @endphp
                                            <div class="rounded-100 py-4 text-center col-12 text-14 fw-500 {{ $status_class }}">{{ booking_status_to_text($val->status) }}</div>
                                        </td>
                                        <td>{{ display_date(strtotime($val->created_at)) }}<br>{{ date('H:i', strtotime($val->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">{{ __("No booking") }}</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script type="text/javascript" src="{{ asset("libs/chart_js/Chart.min.js") }}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $(".bravo-user-render-chart").each(function () {
                let ctx = $(this)[0].getContext('2d');
                window.myMixedChartForVendor = new Chart(ctx, {
                    type: 'bar',//line - bar
                    data: earning_chart_data,
                    options: {
                        min:0,
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                display: true,
                                scaleLabel: {
                                    labelString: '{{__("Timeline")}}'
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: '{{__("Currency: :currency_main",['currency_main'=>setting_item('currency_main')])}}'
                                },
                                ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += tooltipItem.yLabel + " ({{setting_item('currency_main')}})";
                                    return label;
                                }
                            }
                        }
                    }
                });
            });
            $(".bravo-user-chart form select").change(function () {
                $(this).closest("form").submit();
            });

            var start = moment().startOf('week');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                "alwaysShowCalendars": true,
                "opens": "left",
                "showDropdowns": true,
                ranges: {
                    '{{__("Today")}}': [moment(), moment()],
                    '{{__("Yesterday")}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '{{__("Last 7 Days")}}': [moment().subtract(6, 'days'), moment()],
                    '{{__("Last 30 Days")}}': [moment().subtract(29, 'days'), moment()],
                    '{{__("This Month")}}': [moment().startOf('month'), moment().endOf('month')],
                    '{{__("Last Month")}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '{{__("This Year")}}': [moment().startOf('year'), moment().endOf('year')],
                    '{{__('This Week')}}': [moment().startOf('week'), end]
                }
            }, cb).on('apply.daterangepicker', function (ev, picker) {
                $.ajax({
                    url: '{{url('user/reloadChart')}}',
                    data: {
                        chart: 'earning',
                        from: picker.startDate.format('YYYY-MM-DD'),
                        to: picker.endDate.format('YYYY-MM-DD'),
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                        if (res.status) {
                            window.myMixedChartForVendor.data = res.data;
                            window.myMixedChartForVendor.update();
                        }
                    }
                })
            });
            cb(start, end);
        });
    </script>
@endpush
