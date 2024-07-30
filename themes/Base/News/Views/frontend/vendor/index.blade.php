@extends('Layout::user')
@section('content')
    <div class="container-fluid">
        <h2 class="title-bar">
            {{!empty($recovery) ?__('Recovery news') : __("Manage news")}}
            @if(Auth::user()->hasPermission('news_create')&& empty($recovery))
                <a href="{{ route("news.vendor.create") }}" class="btn-change-password">{{__("Add News")}}</a>
            @endif
        </h2>
        @include('admin.message')
        <div class="filter-div filter-div-news d-flex justify-content-between  mb-3">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('news.vendor.bulkEdit')}}"
                          class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control mr-3">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            @if(!setting_item('news_vendor_need_approve'))
                                <option value="publish">{{__(" Publish ")}}</option>
                            @endif
                            <option value="pending">{{__("Move to Pending")}}</option>
                            <option value="draft">{{__(" Move to Draft ")}}</option>
                            <option value="delete">{{__(" Delete ")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="py-2 btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="{{route('news.vendor.index')}} " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    <input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}"
                           class="form-control mr-3">
                    <select name="cate_id" class="form-control mr-3">
                        <option value="">{{ __('--All Category --')}} </option>
                        <?php
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                printf("<option value='%s' >%s</option>", $category->id, $category->name);
                            }
                        }
                        ?>
                    </select>
                    <div class="flex-shrink-0">
                        <button class="btn-info btn btn-icon btn_search py-2" type="submit">{{__('Search News')}}</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
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
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th class="title"> {{ __('Name')}}</th>
                                    <th width="200px"> {{ __('Category')}}</th>
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
                                                <a href="{{route('news.vendor.edit',['id'=>$row->id])}}">{{$row->title}}</a>
                                            </td>
                                            <td>{{$row->cat->name ?? '' }}</td>
                                            <td> {{ display_date($row->updated_at)}}</td>
                                            <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                                            <td>
                                                <a href="{{route('news.vendor.edit',['id'=>$row->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
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
