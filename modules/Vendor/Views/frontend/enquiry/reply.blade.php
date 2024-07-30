@extends('layouts.user')
@section ('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('All Reply')}}</h1>
        </div>
        @include('admin.message')
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <form action="{{route('vendor.enquiry_report.replyStore',['enquiry'=>$enquiry])}}" method="post">
                        @csrf
                    <div class="panel-title"><strong>{{__("Add Reply")}}</strong></div>
                    <div class="panel-body">
                            <div class="form-group">
                                <label>{{__("Client Message:")}}</label>
                                <div><strong>{{__("Name:")}}</strong> {{$enquiry->name}}</div>
                                <div><strong>{{__("Email:")}}</strong> {{$enquiry->email}}</div>
                                <div><strong>{{__("Phone:")}}</strong> {{$enquiry->phone}}</div>
                                <div><strong>{{__("Content:")}}</strong> {{$enquiry->note}}</div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>{{__("Reply Content")}}</label>
                                <textarea required name="content" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Add New')}}</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom border-gray pb-2 mb-0">{{__('Recent updates')}}</h6>
                    @foreach($rows as $row)
                        <div class="media text-muted pt-3">
                            <div class="bd-placeholder-img mr-2 rounded">
                                <img src="{{$row->author->avatar_url}}" class="bd-placeholder-img mr-2 rounded" width="32" height="32" alt="">
                            </div>
                            <div class="d-flex flex-justify-between flex-grow-1">
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray flex-grow-1">
                                    <strong class="d-block text-gray-dark">{{$row->author->display_name}}</strong>
                                    <div>
                                        {!! clean($row->content) !!}
                                    </div>
                                </div>
                                <div class="flex-shrink-0">{{display_datetime($row->created_at)}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end">
                    {{$rows->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
