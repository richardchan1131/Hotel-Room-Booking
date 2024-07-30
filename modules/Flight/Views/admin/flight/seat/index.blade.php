@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Flight: :name :code #:id",['name'=>@$currentFlight->title,'code'=>$currentFlight->code,'id'=>$currentFlight->id])}}</h1>
        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-4 mb40">
                <div class="panel">
                    <div class="panel-title">{{__("Add Flight Seat")}}</div>
                    <div class="panel-body">
                        <form action="{{route('flight.admin.flight.seat.store',['flight_id'=>$currentFlight->id,'id'=>$row->id??-1])}}" method="post">
                            @csrf
                            @include('Flight::admin.flight.seat.form')
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
                            <form method="post" action="{{route('flight.admin.flight.seat.bulkEdit',['flight_id'=>$currentFlight->id])}}" class="filter-form filter-form-left d-flex justify-content-start">
                                {{csrf_field()}}
                                <select name="action" class="form-control">
                                    <option value="">{{__(" Bulk Action ")}}</option>
                                    <option value="delete">{{__(" Delete ")}}</option>
                                </select>
                                <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="col-left">
                        <form method="get" action="{{route('flight.admin.flight.seat.index',['flight_id'=>$currentFlight->id])}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                            <input type="text" name="s" value="{{ Request()->s }}" class="form-control" placeholder="{{__("Search by code")}}">
                            <button class="btn-info btn btn-icon btn_search" id="search-submit" type="submit">{{__('Search')}}</button>
                        </form>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-title">{{__("All Flight seat")}}</div>
                    <div class="panel-body">
                        <form class="bravo-form-item">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th>{{__("Flight")}}</th>
                                    <th>{{__("Seat type")}}</th>
                                    <th >{{__("Price")}}</th>
                                    <th >{{__("Max passengers")}}</th>
                                    <th class="date"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($rows) > 0)
                                    @foreach ($rows as $row)
                                        <tr>
                                            <td><input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}"></td>
                                            <td><a href="{{route('flight.admin.edit',$row->flight)}}">{{$row->flight->title}} {{$row->flight->code}} #{{$row->flight->id}}</a></td>
                                            <td>{{$row->seatType->name}}</td>
                                            <td>{{format_money($row->price)}}</td>
                                            <td>{{$row->max_passengers}}</td>
                                            <td><a class="btn btn-primary btn-sm" href="{{route('flight.admin.flight.seat.edit',['flight_id'=>$currentFlight->id,'id'=>$row->id])}}"><i class="fa fa-edit"></i> {{__('Edit')}}</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">{{__("No data")}}</td>
                                    </tr>
                                @endif
                                </tbody>
                                {{$rows->appends(request()->query())->links()}}
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
