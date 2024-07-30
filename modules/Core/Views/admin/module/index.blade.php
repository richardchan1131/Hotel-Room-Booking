@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("All Modules")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('core.admin.module.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            {{--<option value="active">{{__("Active")}}</option>
                            <option value="deactivate">{{__("Deactivate")}}</option>--}}
                        </select>
                        <button class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            {{--<div class="col-left">
                <form method="get" action="{{route('core.admin.plugins.index')}} " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    <input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}" class="form-control">
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
                </form>
            </div>--}}
        </div>
        <div class="panel">
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th width="200px"> {{ __('Module name')}}</th>
                                <th > {{ __('Description')}}</th>
                                <th width="130px"> {{ __('Author')}}</th>
                                <th width="100px"> {{ __('Version')}}</th>
                                <th width="100px"> {{ __('Status')}}</th>
                                <th width="100px"> {{ __('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($rows))
                                @foreach($rows as $id=>$row)
                                    <tr class="">
                                        <td><input type="checkbox" name="ids[]" class="check-item" value="{{$id}}">
                                        </td>
                                        <td class="title">
                                            <div class="d-flex align-items-center">
                                                @if($thumb = $row::getThumb())
                                                    <div class="mr-3">
                                                        <img src="{{$thumb}}" width="50" height="50" alt="">
                                                    </div>
                                                @endif
                                                <a href="#">{{$row::getName()}}</a>
                                            </div>
                                        </td>
                                        <td>
                                            {{$row::getDesc()}}
                                        </td>
                                        <td>
                                            {{$row::getAuthor()}}
                                        </td>
                                        <td>
                                            {{$row::getVersion()}}
                                        </td>
                                        <td><span class="badge badge-1">1</span></td>
                                        <td>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">{{__("No Module found")}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
