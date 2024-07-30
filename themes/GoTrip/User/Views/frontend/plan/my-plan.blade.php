@extends('layouts.user')
@section('content')
    <h2 class="title-bar">
        {{__("My Current Plan")}}
    </h2>
    @include('admin.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h4>{{__("My Current Plan")}}</h4>
                    </div>
                    <div class="widget-content">
                        @php
                            $user_plans = $user->userPlans;
                        @endphp
                        <table class="table table-bordered table-striped  mb-5">
                            <thead>
                            <tr>
                                <th>{{__("Plan ID")}}</th>
                                <th>{{__("Plan Name")}}</th>
                                <th>{{__("Expiry")}}</th>
                                <th>{{__("Total")}}</th>
                                <th>{{__("Price")}}</th>
                                <th>{{__("Status")}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if($user_plans && count($user_plans) > 0)
                                @foreach($user_plans as $user_plan)
                                    <tr>
                                        <td>#{{$user_plan->plan_id}}</td>
                                        <td class="trans-id">{{$user_plan->plan->title ?? ''}}</td>
                                        <td class="total-jobs">{{display_datetime($user_plan->end_date)}}</td>
                                        <td class="used">@if(!$user_plan->max_service) {{__("Unlimited")}} @else {{$user_plan->used}}/{{$user_plan->max_service}} @endif</td>
                                        <td class="remaining">{{format_money($user_plan->price)}}</td>
                                        <td >
                                            @if($user_plan->status==0)
                                                <div class="text-warning mb-3">{{__('Pending')}}</div>
                                            @elseif($user_plan->is_valid)
                                                <span class="text-success">{{__('Active')}}</span>
                                            @else
                                                <div class="text-danger mb-3">{{__('Expired')}}</div>
                                                <div>
                                                    <a href="{{route('plan')}}" class="btn btn-warning">{{__('Renew')}}</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">
                                        {{__("No Items")}}
                                    </td>
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

