<div class="form-group">
    <label>{{__("List Contact")}}</label>
    <div class="form-controls">
        <div class="form-group-item">
            <div class="form-group-item">
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-4">{{__("Title")}}</div>
                        <div class="col-md-7">{{__('Info Contact')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    <?php
                    $page_contact_lists = setting_item_with_lang('page_contact_lists',request()->query('lang'));
                    if(!empty($page_contact_lists)) $page_contact_lists = json_decode($page_contact_lists,true);
                    if(empty($page_contact_lists) or !is_array($page_contact_lists))
                        $page_contact_lists = [];
                    ?>
                    @foreach($page_contact_lists as $key=>$item)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">{{ __("Title") }}</label>
                                    <input type="text" name="page_contact_lists[{{$key}}][title]" class="form-control" value="{{$item['title'] ?? ""}}">
                                </div>
                                <div class="col-md-7">
                                    <label for="">{{ __("Content") }}</label>
                                    <textarea name="page_contact_lists[{{$key}}][content]" class="form-control">{{$item['content'] ?? ""}}</textarea>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{ __("Title") }}</label>
                                <input type="text" __name__="page_contact_lists[__number__][title]" class="form-control" value="">
                            </div>
                            <div class="col-md-7">
                                <label for="">{{ __("Content") }}</label>
                                <textarea __name__="page_contact_lists[__number__][content]" class="form-control"></textarea>
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="">{{__("Iframe google map")}}</label>
    <div class="form-controls">
        <input type="text" class="form-control" name="page_contact_iframe_google_map" value="{{ setting_item_with_lang('page_contact_iframe_google_map',request()->query('lang')) }}">
    </div>
</div>

<div class="form-group mt-4">
    <h4 class="form-group-title">{{ __("Why Choose Us") }}</h4>
    <div class="row">
       <div class="col-md-6">
           <label class="">{{__("Block: Title")}}</label>
           <div class="form-controls">
               <input type="text" class="form-control" name="page_contact_why_choose_us_title" value="{{ setting_item_with_lang('page_contact_why_choose_us_title',request()->query('lang')) }}">
           </div>
       </div>
       <div class="col-md-6">
           <label class="">{{__("Block: Desc")}}</label>
           <div class="form-controls">
               <input type="text" class="form-control" name="page_contact_why_choose_us_desc" value="{{ setting_item_with_lang('page_contact_why_choose_us_desc',request()->query('lang')) }}">
           </div>
       </div>
    </div>
</div>

<div class="form-group">
    <label>{{__("List Items")}}</label>
    <div class="form-controls">
        <div class="form-group-item">
            <div class="form-group-item">
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-4">{{__("Image")}}</div>
                        <div class="col-md-7">{{__("Title/Desc")}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    <?php
                    $page_contact_why_choose_us = setting_item_with_lang('page_contact_why_choose_us',request()->query('lang'));
                    if(!empty($page_contact_why_choose_us)) $page_contact_why_choose_us = json_decode($page_contact_why_choose_us,true);
                    if(empty($page_contact_why_choose_us) or !is_array($page_contact_why_choose_us))
                        $page_contact_why_choose_us = [];
                    ?>
                    @foreach($page_contact_why_choose_us as $key=>$item)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('page_contact_why_choose_us['.$key.'][image_id]',$item['image_id']) !!}
                                </div>
                                <div class="col-md-7">
                                    <label for="">{{ __("Title") }}</label>
                                    <input type="text" name="page_contact_why_choose_us[{{$key}}][title]" class="form-control" value="{{$item['title'] ?? ""}}">
                                    <label for="">{{ __("Desc") }}</label>
                                    <input type="text" name="page_contact_why_choose_us[{{$key}}][desc]" class="form-control" value="{{$item['desc'] ?? ""}}">
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-4">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('page_contact_why_choose_us[__number__][image_id]','','__name__') !!}
                            </div>
                            <div class="col-md-7">
                                <label for="">{{ __("Title") }}</label>
                                <input type="text" __name__="page_contact_why_choose_us[__number__][title]" class="form-control" value="">
                                <label for="">{{ __("Desc") }}</label>
                                <input type="text" __name__="page_contact_why_choose_us[__number__][desc]" class="form-control" value="">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
