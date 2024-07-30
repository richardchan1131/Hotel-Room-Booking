@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('All Events')}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div row">
            <div class="div col-lg-12">
                @if($rows->count())
                    <form method="post" action="{{route('tracking.admin.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="delete">{{__(" Delete ")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>

            <div class="col-left col-lg-12">
                <div class="panel mb-3">
                    <div class="panel-body">
                        <h5>{{__("Filter:")}}</h5>
                <form method="get" class="mb-0 filter-form filter-form-right d-flex justify-content-start flex-column flex-sm-row" role="search">
                    <div id="reportrange" >
                        <input autocomplete="off" type="text" class="form-control" style="width: 200px;background: white" name="date_str" placeholder="-- Select Date --" value="{{request('date_str')}}">
                        <input type="hidden" name="start_date" value="{{request('start_date')}}">
                        <input type="hidden" name="end_date" value="{{request('end_date')}}">
                    </div>
                    <?php
                    $user = !empty(Request()->vendor_id) ? App\User::find(Request()->vendor_id) : false;
                    \App\Helpers\AdminForm::select2('vendor_id', [
                        'configs' => [
                            'ajax'        => [
                                'url'      => url('/admin/module/user/getForSelect2'),
                                'dataType' => 'json',
                                'data' => array("user_type"=>"vendor")
                            ],
                            'allowClear'  => true,
                            'placeholder' => __('-- Vendor --')
                        ]
                    ], !empty($user->id) ? [
                        $user->id,
                        $user->getDisplayName() . ' (#' . $user->id . ')'
                    ] : false)
                    ?>
                    <select class="form-control" name="event_name">
                        <option value="">{{ __('-- Event Type --')}}</option>
                        <option @if(request('event_name') == 'phone_click') selected @endif value="phone_click">{{__("Phone Click")}}</option>
                        <option @if(request('event_name') == 'website_click') selected @endif value="website_click">{{__("Website Click")}}</option>
                        <option @if(request('event_name') == 'enquiry_click') selected @endif value="enquiry_click">{{__("Enquiry Click")}}</option>
                        <option @if(request('event_name') == 'email_ads_click') selected @endif value="email_ads_click">{{__("Email Ads Click")}}</option>
                    </select>
                    <input data-condition="event_name:is(email_ads_click)" type="text" name="event_sub" class="form-control" placeholder="{{__("Ads Name")}}" value="{{request('event_sub')}}">
                    <select class="form-control" name="object_model">
                        <option value="">{{ __('-- Service Type --')}}</option>
                        <option @if(request('object_model') == 'tour') selected @endif value="tour">{{__("Tour")}}</option>
                        <option @if(request('object_model') == 'hotel') selected @endif value="hotel">{{__("Hotel")}}</option>
                        <option @if(request('object_model') == 'event') selected @endif value="event">{{__("Event")}}</option>
                        <option @if(request('object_model') == 'campaign') selected @endif value="campaign">{{__("Campaign")}}</option>
                    </select>
                    <input type="text" name="object_id" class="form-control" placeholder="{{__("Service ID")}}" value="{{request('object_id')}}">
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
                </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
        </div>
        <div class="panel">
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th>{{__('Event')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('Lang')}}</th>
                                <th>{{__('Country')}}</th>
                                <th>{{__('Ip')}}</th>
                                <th>{{__('Payout ID')}}</th>
                                <th>{{__("CPC")}}</th>
                                <th>{{__('Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="{{$row->id}}" class="check-item"></td>
                                    <td class="title">
                                        {{$row->event_name}} {{$row->event_sub_name}}
                                    </td>
                                    <td>{{ucfirst($row->object_model).' #'.$row->object_id}} <a target="_blank" href="{{route('tracking.go',['id'=>$row->id])}}"><i class="fa fa-eye"></i></a></td>
                                    <td>{{$row->browser_lang}}</td>
                                    <td>{{$row->geoip_country_name}}</td>
                                    <td>{{$row->client_ip}}</td>
                                    <td>{{$row->payout_id  ? '#'.$row->payout_id : ''}}</td>
                                    <td>{{ $row->cpc}}</td>
                                    <td>{{ display_datetime($row->created_at)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                {{$rows->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
@endsection

@section('script.body')

    <script src="{{url('libs/daterange/moment.min.js')}}"></script>
    <script src="{{url('libs/daterange/daterangepicker.min.js?_ver='.config('app.version'))}}"></script>
    <link rel="stylesheet" href="{{url('libs/daterange/daterangepicker.css')}}"/>
    <script>
        @if(request('start_date') and request('end_date'))
            var start = moment('{{request('start_date')}}');
            var end = moment('{{request('end_date')}}');
        @else
            var start = false;
            var end = false;
        @endif

        function cb(start, end) {
            $('#reportrange [name=date_str]').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#reportrange input[name=start_date]').val(start.format('YYYY-MM-DD'));
            $('#reportrange input[name=end_date]').val(end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({
            startDate: start ? start : false,
            endDate: end ? end : false,
            "alwaysShowCalendars": true,
            // "opens": "center",
            // "showDropdowns": true,
            autoUpdateInput: false,
            {{--ranges: {--}}
            {{--    '{{__("Today")}}': [moment(), moment()],--}}
            {{--    '{{__("Yesterday")}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],--}}
            {{--    '{{__("Last 7 Days")}}': [moment().subtract(6, 'days'), moment()],--}}
            {{--    '{{__("Last 30 Days")}}': [moment().subtract(29, 'days'), moment()],--}}
            {{--    '{{__("This Month")}}': [moment().startOf('month'), moment().endOf('month')],--}}
            {{--    '{{__("Last Month")}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],--}}
            {{--    '{{__("This Year")}}': [moment().startOf('year'), moment().endOf('year')],--}}
            {{--    '{{__('This Week')}}': [moment().startOf('week'), end]--}}
            {{--}--}}
        }, cb).on('apply.daterangepicker', function (ev, picker) {
            $('#reportrange input[name=start_date]').val(picker.startDate.format('YYYY-MM-DD'));
            $('#reportrange input[name=end_date]').val(picker.endDate.format('YYYY-MM-DD'));
        });
    </script>
@endsection
