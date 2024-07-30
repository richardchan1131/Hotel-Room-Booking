@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('All Page')}}</h1>
            <div class="title-actions">
                <a href="{{route('page.admin.create')}}" class="btn btn-primary">{{ __('Add new page')}}</a>
            </div>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                <form method="post" action="{{route('page.admin.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                    {{csrf_field()}}
                    <select name="action" class="form-control">
                        <option value="">{{__(" Bulk Actions ")}}</option>
                        <option value="publish">{{__(" Publish ")}}</option>
                        <option value="draft">{{__(" Move to Draft ")}}</option>
                        <option value="delete">{{__(" Delete ")}}</option>
                    </select>
                    <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                </form>
               @endif
            </div>
            <div class="col-left">
               <form method="get" action="{{route('page.admin.index')}} " class="filter-form filter-form-right d-flex justify-content-end" role="search">
                    <input  type="text" name="page_name" value="{{ Request()->page_name }}" placeholder="{{__('Search by name')}}" class="form-control">
                    <button class="btn-info btn btn-icon btn_search"  type="submit">{{__('Search Page')}}</button>
                </form>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="60px"><input type="checkbox" class="check-all"></th>
                                <th >{{ __('Title')}}</th>
                                <th width="130px">{{ __('Author')}} </th>
                                <th width="100px">{{__('Date')}} </th>
                                <th width="100px">{{__('Status')}} </th>
                                <th width="100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rows->total() > 0)
                                @foreach($rows as $row)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" class="check-item" value="{{$row->id}}"></td>
                                        <td class="title">
                                            <a href="{{route('page.admin.edit',['id'=>$row->id])}}"> {{$row->title}}  </a>
                                            @if(setting_item('home_page_id') == $row->id)
                                                <div class="badge badge-info">{{__("Homepage")}}</div>
                                            @endif
                                        </td>
                                        <td class="author">
                                            @if(!empty($row->author))
                                                {{$row->author->getDisplayName()}}
                                            @else
                                                {{__("[Author Deleted]")}}
                                            @endif
                                        </td>
                                        <td class="date">{{ display_date($row->updated_at)}}</td>
                                        <td> <span class="badge badge-{{ $row->status }}">{{ $row->status }}</span> </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    {{__("Actions")}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="{{route('page.admin.edit',['id'=>$row->id])}}" class="dropdown-item"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
                                                    <a href="{{route('page.admin.builder',['id'=>$row->id])}}" class="dropdown-item"><i class="fa fa-paint-brush"></i> {{__('Template Builder')}}</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="{{route('page.detail',['slug'=>$row->slug])}}" class="dropdown-item"><i class="fa fa-eye"></i> {{__('View')}}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">{{__("No data")}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{$rows->appends(request()->query())->links()}}
            </div>
        </div>
    </div>
@endsection
