@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600"> {{__("Wallet")}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto">
            <a href="{{route('user.wallet.buy')}}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">{{__("Buy credits")}}</a>
        </div>
    </div>
    @include('admin.message')
    <div class="bravo-user-dashboard">
        <div class="row dashboard-price-info row-eq-height mb-5">
            <div class="col-lg-3 col-md-3">
                <div class="dashboard-item">
                    <div class="wrap-box">
                        <div class="title">
                            {{"Credit balance"}}
                        </div>
                        <div class="details">
                            <div class="number">{{__(':amount',['amount'=>$row->balance])}}</div>
                        </div>
                        @if($row->balance)
                        <div class="desc">~ {{format_money(credit_to_money($row->balance))}} </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-title"><strong >{{__("Latest Transactions")}}</strong></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('Type')}}</th>
                            <th scope="col">{{__('Amount')}}</th>
                            <th scope="col">{{__('Gateway')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__("Description")}}</th>
                            <th scope="col">{{__("Date")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($transactions))
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->id}}</td>
                                        <td>{{ucfirst($transaction->type)}}</td>
                                        <td>{{$transaction->amount}}</td>
                                        <td>
                                            @if($transaction->payment->gateway_obj)
                                                {{$transaction->payment->gateway_obj->getDisplayName() ?? ''}}
                                            @endif
                                        </td>
                                        <td><span class="badge badge-{{$transaction->status_class}}">{{$transaction->status_name ?? ''}}</span></td>
                                        <td>
                                            @if(!empty($transaction->meta['admin_deposit']))
                                                {{__("Deposit by :name",['name'=>$transaction->author->display_name ?? ''])}}
                                            @endif
                                        </td>
                                        <td>{{display_datetime($transaction->created_at)}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5">{{__("No data found")}}</td></tr>
                            @endif
                        </tbody>
                        {{$transactions->links()}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
