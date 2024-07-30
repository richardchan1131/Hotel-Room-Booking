@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("All tickets")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form
                        method="post"
                        action="{{route('support.admin.ticket.bulkEdit')}}"
                        class="filter-form filter-form-left d-flex justify-content-start"
                    >
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="publish">{{__(" Publish ")}}</option>
                            <option value="draft">{{__(" Move to Draft ")}}</option>
                            <option value="delete">{{__(" Delete ")}}</option>
                        </select>
                        <button
                            data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button"
                        >{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form
                    method="get"
                    action="{{route('support.admin.ticket.index')}} "
                    class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row"
                    role="search"
                >
                    <input
                        type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}" class="form-control"
                    >
                    <select name="cat_id" class="form-control">
                        <option value="">{{ __('--All Category --')}} </option>
                        <?php
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                printf("<option value='%s' %s >%s</option>", $category->id, request('cat_id') == $category->id ? "selected" : '', strtoupper($category->product_line) . ' - ' . $category->name);
                            }
                        }
                        ?>
                    </select>
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search topic')}}</button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p>
                <i>{{__('Found :total items',['total'=>$rows->total()])}}</i>
            </p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" class="bravo-form-item">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th width="60px">
                                            <input type="checkbox" class="check-all">
                                        </th>
                                        <th class="title"> {{ __('Name')}}</th>
                                        <th width="200px"> {{ __('Category')}}</th>
                                        <th width="130px"> {{ __('Customer')}}</th>
                                        <th width="130px"> {{ __('Agent')}}</th>
                                        <th width="100px"> {{ __('Date')}}</th>
                                        <th width="100px">{{  __('Status')}}</th>
                                        <th width="100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($rows->total() > 0)
                                        @foreach($rows as $row)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}">
                                                </td>
                                                <td class="title">
                                                    <a href="{{$row->getEditUrl()}}">{{$row->title}}</a>
                                                </td>
                                                <td>{{$row->cat->name ?? '' }}</td>
                                                <td>
                                                    {{$row->customer->display_name ?? ''}}
                                                </td>
                                                <td>
                                                    @if($row->agent)
                                                        {{$row->agent->display_name}}
                                                    @else
                                                        <div class="badge badge-warning">{{__('Unassigned')}}</div>
                                                    @endif
                                                </td>
                                                <td> {{ display_date($row->updated_at)}}</td>
                                                <td>
                                                    <span class="badge badge-{{ $row->status }}">{{ $row->status }}</span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            type="button"
                                                            data-toggle="dropdown"
                                                            aria-expanded="false"
                                                        >
                                                            {{__("Actions")}}
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="{{$row->getEditUrl()}}" class="dropdown-item">
                                                                <i class="fa fa-edit"></i> {{__('View Ticket')}}</a>
                                                        </div>
                                                    </div>
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
                            </div>
                        </form>
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
