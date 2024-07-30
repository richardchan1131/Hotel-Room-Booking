@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{ $page_title }}</h1>
            <div class="text-15 text-light-1">{{ __("Lorem ipsum dolor sit amet, consectetur.") }}</div>
        </div>
        <div class="col-auto"></div>
    </div>
    @include('admin.message')
    <div class="booking-history-manager">
        <div class="tabbable">
            <div class="overflow-scroll scroll-bar-1">
                <table class="table-3 -border-bottom col-12">
                    <thead class="bg-light-2">
                    <tr>
                        <th width="2%">{{__("Type")}}</th>
                        <th>{{__('Service Info')}}</th>
                        <th>{{__('Customer Info')}}</th>
                        <th width="80px">{{__('Status')}}</th>
                        <th width="80px">{{__('Replies')}}</th>
                        <th width="180px">{{__('Created At')}}</th>
                        <th>{{__("Action")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($rows->total() > 0)
                        @foreach($rows as $row)
                            <tr>
                                <td class="booking-history-type d-flex items-center">
                                    @if($service = $row->service)
                                        <i class="{{$service->getServiceIconFeatured()}}"></i>
                                    @endif
                                    <small class="ml-2 text-capitalize">{{$row->object_model}}</small>
                                </td>
                                <td>
                                    @if($service = $row->service)
                                        <a href="{{$service->getDetailUrl()}}" target="_blank">{{$service->title ?? ''}}</a>
                                    @else
                                        {{__("[Deleted]")}}
                                    @endif
                                </td>
                                <td>
                                    <div>{{__("Name:")}} {{$row->name}}</div>
                                    <div>{{__("Email:")}} {{$row->email}}</div>
                                    <div>{{__("Phone:")}} {{$row->phone}}</div>
                                    <div>{{__("Notes:")}} {{$row->note}}</div>
                                </td>
                                <td>
                                    <span class="label label-{{$row->status}}">{{$row->statusName}}</span>
                                </td>
                                <td>{{$row->replies_count}}</td>
                                <td>{{display_datetime($row->updated_at)}}</td>
                                <td width="5%">
                                    @if(!empty( $has_permission_enquiry_update ))
                                        <div class="dropdown js-dropdown js-actions-1-active">
                                            <div class="dropdown__button d-flex items-center rounded-4 text-blue-1 bg-blue-1-05 text-14 px-15 py-5" data-el-toggle=".js-actions-1-toggle" data-el-toggle-active=".js-actions-1-active">
                                                <span class="js-dropdown-title">{{__("Action")}}</span>
                                                <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                            </div>
                                            <div class="toggle-element -dropdown-2 js-click-dropdown js-actions-1-toggle w-200 start-0" style="max-width:none;left: 0">
                                                <div class="text-14 fw-500 js-dropdown-list">
                                                    <div>
                                                        <a class="d-block" href="{{route('vendor.enquiry_report.reply',['enquiry'=>$row])}}"><i class="icofont-long-arrow-right"></i> {{__("Add Reply")}}</a>
                                                    </div>
                                                    @if(!empty($statues))
                                                        @foreach($statues as $status)
                                                            <div>
                                                                <a class="d-block" href="{{ \Illuminate\Support\Facades\URL::signedRoute("vendor.enquiry_report.bulk_edit" , ['id'=>$row->id , 'status'=>$status]) }}">
                                                                    <i class="icofont-long-arrow-right"></i> {{__('Mark as: :name',['name'=>booking_status_to_text($status)])}}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">{{__("No data")}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="bravo-pagination pt-30">
                    {{$rows->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
