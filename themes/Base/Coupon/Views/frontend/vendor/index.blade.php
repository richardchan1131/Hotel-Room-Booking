@extends('layouts.user')
@section('content')
    <h2 class="title-bar">
        {{ __("Manage Coupon") }}
        @if(Auth::user()->hasPermission('coupon_create') && empty($recovery))
            <a href="{{ route("coupon.vendor.create") }}" class="btn-change-password">{{__("Add Coupon")}}</a>
        @endif
    </h2>
    @include('admin.message')
    @if($rows->total() > 0)
        <div class="bravo-list-item">
            <div class="bravo-pagination">
                <span class="count-string">{{ __("Showing :from - :to of :total coupon",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                {{$rows->appends(request()->query())->links()}}
            </div>
            <div class="list-item">
                <div class="booking-history-manager">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-booking-history mb-0">
                                <thead>
                                <tr>
                                    <th> {{ __('Code')}}</th>
                                    <th> {{ __('Name')}}</th>
                                    <th> {{ __('Amount')}}</th>
                                    <th> {{ __('Discount Type')}}</th>
                                    <th> {{ __('End Date')}}</th>
                                    <th width="100px"> {{ __('Status')}}</th>
                                    <th width="100px"> {{ __("Action") }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $row)
                                        <tr class="{{$row->status}}">
                                            <td class="title">
                                                <strong>{{$row->code}}</strong>
                                            </td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->amount}}</td>
                                            <td>{{$row->discount_type == 'percent' ? __("Percent") : __("Amount")}}</td>
                                            <td>{{ ($row->end_date) }}</td>
                                            <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                                            <td>
                                                <a href="{{route('coupon.vendor.edit',['id'=>$row->id])}}" class="btn btn-xs btn-primary btn-info-booking mt-1"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
                                                <a href="{{route('coupon.vendor.delete',['id'=>$row->id])}}" class="btn btn-xs btn-secondary btn-info-booking mt-1"><i class="fa fa-remove"></i> {{__('Delete')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bravo-pagination">
                <span class="count-string">{{ __("Showing :from - :to of :total coupon",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                {{$rows->appends(request()->query())->links()}}
            </div>
        </div>
    @else
        {{__("No Coupon")}}
    @endif
@endsection
