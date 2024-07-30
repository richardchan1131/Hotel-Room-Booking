<?php
if(is_default_lang()){
    $meta_seo = $row->getSeoMeta();
}else{
    $meta_seo = $translation->getSeoMeta(request()->query('lang'));
}
$seo_share = $meta_seo['seo_share'] ?? false;
$desc = $meta_seo['seo_desc'] ?? $meta_seo['service_desc'] ?? '';
?>
<div class="panel">
    <div class="panel-title d-flex justify-content-between align-items-center py-2"><strong>{{__("Search engine")}}</strong>
        <a href="#" data-toggle="modal" data-target="#seo_config" class="btn btn-sm btn-link">{{__("Edit")}}</a>
    </div>
    <div class="panel-body">
        <div class="seo-preview max-w-650">
            <div class="d-flex align-items-center mb-2">
                <div class="seo-favicon w-28 h-28 mr-2 d-flex align-items-center justify-content-center">
                    @php
                        $favicon = setting_item('site_favicon');
                    @endphp
                    @if($favicon)
                        @php
                            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
                        @endphp
                        @if(!empty($file))
                            <img rel="icon" class="w-18 h-18" type="{{$file['file_type']}}" src="{{asset('uploads/'.$file['file_path'])}}" />
                        @else
                            :
                            <img rel="icon" class="w-18 h-18" type="image/png" src="{{url('images/favicon.png')}}" />
                        @endif
                    @endif
                </div>
                <div>
                    <div class="seo-site-name text-14">{{setting_item_with_lang('site_title',request('lang'))}}</div>
                    <div class="seo-url text-12">{{$meta_seo['full_url'] ?? url('/')}}</div>
                </div>
            </div>
            <div>
                <div class="seo-title text-20 mb-2">
                    <span class="val">{{$meta_seo['seo_title'] ?? $row->title ?? $row->name}}</span>
                </div>
                <div class="seo-desc text-14">{{$desc}}</div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="seo_config">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Search Engine")}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if(!is_default_lang()) d-none @endif ">
                            <label class="control-label">
                                {{__("Allow search engines to show this service in search results?")}}
                            </label>
                            <select name="seo_index" class="form-control">
                                <option
                                    value="1"
                                    @if(isset($meta_seo['seo_index']) and $meta_seo['seo_index'] == 1) selected @endif>{{__("Yes")}}</option>
                                <option
                                    value="0" @if(isset($meta_seo['seo_index']) and $meta_seo['seo_index'] == 0) selected @endif>{{__("No")}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mb-2" data-condition="seo_index:is(1)">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#seo_1">{{__("General Options")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo_2">{{__("Share Facebook")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo_3">{{__("Share Twitter")}}</a>
                    </li>
                </ul>
                <div class="tab-content" data-condition="seo_index:is(1)">
                    <div class="tab-pane active" id="seo_1">
                        <div class="form-group">
                            <label class="control-label">{{__("Seo Title")}}</label>
                            <input
                                type="text"
                                name="seo_title"
                                class="form-control"
                                placeholder="{{ $row->title ?? $row->name ?? __("Leave blank to use service title")}}"
                                value="{{ $meta_seo['seo_title'] ?? ""}}"
                            >
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__("Seo Description")}}</label>
                            <textarea
                                name="seo_desc" rows="3" class="form-control" placeholder="{{$desc ?? __("Enter description...")}}"
                            >{{$meta_seo['seo_desc'] ?? ""}}</textarea>
                        </div>
                        @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Featured Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('seo_image', $meta_seo['seo_image'] ?? "" ) !!}
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="seo_2">
                        <div class="form-group">
                            <label class="control-label">{{__("Facebook Title")}}</label>
                            <input
                                type="text"
                                name="seo_share[facebook][title]"
                                class="form-control"
                                placeholder="{{ $row->title ?? $row->name ?? __("Enter title...")}}"
                                value="{{$seo_share['facebook']['title'] ?? "" }}"
                            >
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__("Facebook Description")}}</label>
                            <textarea
                                name="seo_share[facebook][desc]"
                                rows="3"
                                class="form-control"
                                placeholder="{{$row->short_desc ?? __("Enter description...")}}"
                            >{{$seo_share['facebook']['desc'] ?? "" }}</textarea>
                        </div>
                        @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Facebook Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="seo_3">
                        <div class="form-group">
                            <label class="control-label">{{__("Twitter Title")}}</label>
                            <input
                                type="text"
                                name="seo_share[twitter][title]"
                                class="form-control"
                                placeholder="{{ $row->title ?? $row->name ?? __("Enter title...")}}"
                                value="{{$seo_share['twitter']['title'] ?? "" }}"
                            >
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__("Twitter Description")}}</label>
                            <textarea
                                name="seo_share[twitter][desc]"
                                rows="3"
                                class="form-control"
                                placeholder="{{$row->short_desc ?? __("Enter description...")}}"
                            >{{$seo_share['twitter']['desc'] ?? "" }}</textarea>
                        </div>
                        @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Twitter Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">{{__("Apply")}}</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#seo_config').on('hide.bs.modal', function() {
            const form = $(this);
            const preview = $('.seo-preview');
            const title = form.find('[name=seo_desc]').val();
            if (title) {
                preview.find('.seo-title .val').html(title);
            }
            const desc = form.find('[name=seo_desc]').val();
            if (desc) {
                preview.find('.seo-desc').html(desc);
            }
        });
    </script>

@endpush
