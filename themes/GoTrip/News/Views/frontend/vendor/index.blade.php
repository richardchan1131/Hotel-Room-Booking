@extends('Layout::user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600"> {{!empty($recovery) ?__('Recovery news') : __("Manage news")}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto">
            @if(Auth::user()->hasPermission('news_create')&& empty($recovery))
                <a href="{{ route("news.vendor.create") }}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                    {{__("Add News")}} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            @endif
        </div>
    </div>
    @include('admin.message')
    <div class="py-30 px-30 rounded-4 bg-white shadow-3">
        <div class="filter-div d-flex justify-content-between  mb-3">
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
