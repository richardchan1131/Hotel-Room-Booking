@extends('Layout::user')

@section('content')
    <form action="{{route('news.vendor.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post" class="dungdt-form">
        <div class="container-fluid">

            <h2 class="title-bar d-flex justify-content-between align-items-center">
                {{$row->id ? __('Edit post: ').$row->title : __('Add new Post')}}
                @if($row->slug)
                    <a class="btn btn-primary btn-sm" href="{{$row->getDetailUrl(request()->query('lang'))}}" target="_blank">{{__("View Post")}}</a>
                @endif
            </h2>
            @include('admin.message')
            @include('Language::admin.navigation')
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('News content')}}</strong></div>
                            <div class="panel-body">
                                @csrf
                                @include('News::frontend.vendor.form',['row'=>$row])
                            </div>
                        </div>
                        @include('Core::admin/seo-meta/seo-meta')
                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong>{{__('Status')}}</strong></div>
                            <div class="panel-body">
                                @if(is_default_lang())
                                    <select name="status" class="form-control">
                                        <option @if($row->status=='draft') selected @endif value="draft">{{ __('Draft')}} </option>
                                        <option @if($row->status=='pending') selected @endif value="pending">{{ __('Pending')}} </option>
                                        @if(!setting_item('news_vendor_need_approve') or $row->status == 'publish')
                                            <option @if(setting_item('news_vendor_need_approve')) disabled @endif @if($row->status=='publish') selected @endif value="publish">{{ __('Publish')}} </option>
                                        @endif
                                    </select>
                                @endif
                            </div>
                            <div class="panel-footer">

                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>

                        @if(is_default_lang())
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>{{  __('Category')}} </label>
                                        <select name="cat_id" class="form-control">
                                            <option value="">{{ __('-- Please Select --')}} </option>
                                            <?php
                                            $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
                                                foreach ($categories as $category) {
                                                    $selected = '';
                                                    if ($row->cat_id == $category->id)
                                                        $selected = 'selected';
                                                    printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                                                    $traverse($category->children, $prefix . '-');
                                                }
                                            };
                                            $traverse($categories);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"> {{ __('Tag')}}</label>
                                        <div class="">
                                            <input type="text" data-role="tagsinput" value="{{$row->tag}}" placeholder="{{ __('Enter tag')}}" name="tag" class="form-control tag-input">
                                            <br>
                                            <div class="show_tags">
                                                @if(!empty($tags))
                                                    @foreach($tags as $tag)
                                                        <span class="tag_item">{{$tag->name}}<span data-role="remove"></span>
                                                    <input type="hidden" name="tag_ids[]" value="{{$tag->id}}">
                                                </span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(is_default_lang())
                            <div class="panel">
                                <div class="panel-body">
                                    <h3 class="panel-body-title"> {{ __('Feature Image')}}</h3>
                                    <div class="form-group">
                                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
@endpush
