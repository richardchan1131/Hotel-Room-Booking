@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("User Plans")}}</h1>
        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-4 mb40">
                <div class="panel">
                    <div class="panel-title">{{__("Add Plan")}}</div>
                    <div class="panel-body">
                        <form action="{{route('user.admin.plan.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
                            @csrf
                            @include('User::admin.plan.form',['parents'=>$rows])
                            <div class="">
                                <button class="btn btn-primary" type="submit">{{__("Add new")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        @if(!empty($rows))
                            <form method="post" action="{{route('user.admin.plan.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                                {{csrf_field()}}
                                <select name="action" class="form-control">
                                    <option value="">{{__(" Bulk Action ")}}</option>
                                    <option value="publish">{{__(" Publish ")}}</option>
                                    <option value="draft">{{__(" Move to Draft ")}}</option>
                                    <option value="delete">{{__(" Delete ")}}</option>
                                </select>
                                <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="col-left">
                        <form method="get" action="" class="filter-form filter-form-right d-flex justify-content-end" role="search">
                            <input type="text" name="s" value="{{ Request()->s }}" class="form-control" placeholder="{{__("Search by name")}}">
                            <button class="btn-info btn btn-icon btn_search" id="search-submit" type="submit">{{__('Search')}}</button>
                        </form>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th width="60px">{{__("ID")}}</th>
                                    <th>{{__("Name")}}</th>
                                    <th>{{__("For Role")}}</th>
                                    <th width="60px">{{__("Price")}}</th>
                                    <th width="60px">{{__("Annual Price")}}</th>
                                    <th width="60px">{{__("Duration")}}</th>
                                    <th width="60px">{{__("Max Services")}}</th>
                                    <th width="60px">{{__("Status")}}</th>
                                    <th width="60px">{{__("Date")}}</th>
                                    <th width="100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $row)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{$row->id}}" class="check-item">
                                        <td>#{{$row->id}}</td>
                                        <td class="title">
                                            <a href="{{route('user.admin.plan.edit',['id'=>$row->id])}}">{{$row->title}}</a>
                                        </td>
                                        <td>{{$row->role->name ?? ''}}</td>
                                        <td class="">{{$row->price ? format_money($row->price) : __("Free")}}</td>
                                        <td class="">{{$row->annual_price ? format_money($row->annual_price) : ''}}</td>
                                        <td class="">{{$row->duration_text}}</td>
                                        <td class="">{{$row->max_service ? $row->max_service : __('Unlimited')}}</td>
                                        <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                                        <td class="">{{ display_date($row->updated_at)}}</td>
                                        <td class="title">
                                            <a href="{{route('user.admin.plan.edit',['id'=>$row->id])}}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> {{__("Edit")}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$rows->appends(request()->query())->links()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
