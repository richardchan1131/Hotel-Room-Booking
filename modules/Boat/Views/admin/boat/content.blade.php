<div class="panel">
    <div class="panel-title"><strong>{{__("Boat Content")}}</strong></div>
    <div class="panel-body">
        <div class="form-group magic-field" data-id="title" data-type="title">
            <label class="control-label">{{__("Title")}}</label>
            <input type="text" value="{{$translation->title}}" placeholder="{{__("Title")}}" name="title" class="form-control">
        </div>
        <div class="form-group magic-field" data-id="content" data-type="content">
            <label class="control-label">{{__("Content")}}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" id="content" cols="30" rows="10">{{$translation->content}}</textarea>
            </div>
        </div>
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Youtube Video")}}</label>
                <input type="text" name="video" class="form-control" value="{{$row->video}}" placeholder="{{__("Youtube link video")}}">
            </div>
        @endif
        <div class="form-group-item">
            <label class="control-label">{{__('FAQs')}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->faqs))
                    @php if(!is_array($translation->faqs)) $translation->faqs = json_decode($translation->faqs); @endphp
                    @foreach($translation->faqs as $key=>$faq)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="faqs[{{$key}}][title]" class="form-control" value="{{$faq['title']}}" placeholder="{{__('Eg: When and where does the tour end?')}}">
                                </div>
                                <div class="col-md-6">
                                    <textarea name="faqs[{{$key}}][content]" class="form-control" placeholder="...">{{$faq['content']}}</textarea>
                                </div>
                                <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="faqs[__number__][title]" class="form-control" placeholder="{{__('Eg: Can I bring my pet?')}}">
                        </div>
                        <div class="col-md-6">
                            <textarea __name__="faqs[__number__][content]" class="form-control" placeholder=""></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Banner Image")}}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id',$row->banner_image_id) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">{{__("Gallery")}}</label>
                {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
            </div>
        @endif
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{__("Extra Info")}}</strong></div>
    <div class="panel-body">
        @if(is_default_lang())
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__("Guest")}}</label>
                        <input type="number" value="{{$row->max_guest}}" placeholder="{{__("Example: 3")}}" name="max_guest" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__("Cabin")}}</label>
                        <input type="text" value="{{$row->cabin}}" placeholder="{{__("Example: 5")}}" name="cabin" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__("Length")}}</label>
                        <input type="number" value="{{$row->length}}" placeholder="{{__("Example: 30m")}}" name="length" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__("Speed")}}</label>
                        <input type="number" value="{{$row->speed}}" placeholder="{{__("Example: 25km/h")}}" name="speed" class="form-control">
                    </div>
                </div>
            </div>
        @endif
        <div class="form-group-item">
            <label class="control-label">{{__('Specs')}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->specs))
                    @php if(!is_array($translation->specs)) $translation->faqs = json_decode($translation->specs); @endphp
                    @foreach($translation->specs as $key=>$spec)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="specs[{{$key}}][title]" class="form-control" value="{{$spec['title']}}" placeholder="{{__('Eg: Range')}}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="specs[{{$key}}][content]" class="form-control" value="{{$spec['content']}}" placeholder="{{__('Eg: 6000km')}}">
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="specs[__number__][title]" class="form-control" placeholder="{{__('Eg: Range')}}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" __name__="specs[__number__][content]" class="form-control" value="" placeholder="{{__('Eg: 6000km')}}">
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>{{__("Cancellation Policy")}}</label>
            <textarea name="cancel_policy" class="form-control" rows="5" placeholder="{{ __("Full refund up to 4 days prior.") }}">{{$translation->cancel_policy}}</textarea>
        </div>
        <div class="form-group">
            <label>{{__("Additional Terms & Information")}}</label>
            <textarea name="terms_information" class="d-none has-ckeditor" rows="10" placeholder="{{ __("For Sanitary purposes ONLY, although there is a working toilet and shower, we've deactivated the shower and the toliet is for limited use (urine only..pardon the graphic detail!)...") }}">{{$translation->terms_information}}</textarea>
        </div>
        @include('Boat::admin/boat/include-exclude')
    </div>
</div>
