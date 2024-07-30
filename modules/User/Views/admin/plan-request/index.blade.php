@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('Plan request management')}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('user.admin.plan_request.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="completed">{{__("Mark as completed")}}</option>
                            <option value="cancelled">{{__("Mark as cancelled")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="" class="filter-form filter-form-right d-flex justify-content-end">
                    <select name="status" class="form-control">
                        <option value="">{{__("-- Status --")}}</option>
                        <option @if(request()->query('status') == 'fail') selected @endif value="fail">{{__("Failed")}}</option>
                        <option @if(request()->query('status') == 'processing') selected @endif value="processing">{{__("Processing")}}</option>
                        <option @if(request()->query('status') == 'completed') selected @endif value="completed">{{__("Completed")}}</option>
                    </select>
                    @csrf
                    <?php
                    $user = !empty(Request()->user_id) ? App\User::find(Request()->user_id) : false;
                    \App\Helpers\AdminForm::select2('user_id', [
                        'configs' => [
                            'ajax'        => [
                                'url'      => route('user.admin.getForSelect2'),
                                'dataType' => 'json'
                            ],
                            'allowClear'  => true,
                            'placeholder' => __('-- User --')
                        ]
                    ], !empty($user->id) ? [
                        $user->id,
                        $user->name_or_email . ' (#' . $user->id . ')'
                    ] : false)
                    ?>
                    <button class="btn-info btn btn-icon" type="submit">{{__('Filter')}}</button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
        </div>
        <div class="panel booking-history-manager">
            <div class="panel-title">{{__('Purchase logs')}}</div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover bravo-list-item">
                        <thead>
                        <tr>
                            <th width="80px"><input type="checkbox" class="check-all"></th>
                            <th>{{__('Customer')}}</th>
                            <th>{{__('Plan')}}</th>
                            <th width="80px">{{__('Amount')}}</th>
                            <th width="80px">{{__('Status')}}</th>
                            <th width="150px">{{__('Payment Method')}}</th>
                            <th width="120px">{{__('Created At')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($rows->total())
                            @foreach($rows as $row)
                                <tr>
                                    <td><input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}">
                                        #{{$row->id}}</td>
                                    <td>
                                        @if($row->user)
                                            <a target="_blank" href="{{route('user.admin.detail',['id' => $row->user->id])}}">{{$row->user->display_name}}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($row->plan))
                                            <p>{{__('Name: :name',['name'=>$row->plan->title])}}

                                            @if($row->getMeta('annual')!=1)
                                                <p>{{__('Duration:  :duration_text',['duration_text'=>$row->plan->duration_text])}}</p>
                                                @else
                                                <p>{{__('Year')}}</p>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{format_money_main($row->amount)}}</td>
                                    <td>
                                        <span class="badge badge-{{$row->status_badge}}">{{$row->statusName}}</span>
                                    </td>
                                    <td>
                                        {{$row->gatewayObj ? $row->gatewayObj->getDisplayName() : ''}}
                                    </td>
                                    <td>{{display_datetime($row->updated_at)}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center"><b>{{ __("No data") }}</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            {{$rows->links()}}
        </div>
    </div>
@endsection
