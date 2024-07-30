<div class="form-group">
    <label>{{__("Footer Style")}}</label>
    <select name="footer_style" class="form-control">
        <option value="normal" @if(setting_item('footer_style') == 'normal') selected @endif>{{ __('Normal') }}</option>
        <option value="style_1" @if(setting_item('footer_style') == 'style_1') selected @endif>{{ __('Style 1') }}</option>
        <option value="style_2" @if(setting_item('footer_style') == 'style_2') selected @endif>{{ __('Style 2') }}</option>
        <option value="style_3" @if(setting_item('footer_style') == 'style_3') selected @endif>{{ __('Style 3') }}</option>
        <option value="style_4" @if(setting_item('footer_style') == 'style_4') selected @endif>{{ __('Style 4') }}</option>
        <option value="style_5" @if(setting_item('footer_style') == 'style_5') selected @endif>{{ __('Style 5') }}</option>
        <option value="style_6" @if(setting_item('footer_style') == 'style_6') selected @endif>{{ __('Style 6') }}</option>
        <option value="style_7" @if(setting_item('footer_style') == 'style_7') selected @endif>{{ __('Style 7') }}</option>
        <option value="style_8" @if(setting_item('footer_style') == 'style_8') selected @endif>{{ __('Style 8') }}</option>
    </select>
</div>

<div class="form-group">
    <label>{{__("Footer content left")}}</label>
    <div class="form-controls">
        <div class="form-group-item">
            <div class="form-group-item">
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Title")}}</div>
                        <div class="col-md-6">{{__('Content')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @php $contents = setting_item('footer_content_left');@endphp
                    @if(!empty($contents))
                        @php $contents = json_decode($contents); @endphp
                        @foreach($contents as $k => $content)
                            <div class="item" data-number="{{$k}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="footer_content_left[{{$k}}][title]" class="form-control" value="{{$content->title}}">
                                    </div>
                                    <div class="col-md-6">
                                        <textarea name="footer_content_left[{{$k}}][content]" class="form-control" rows="5">{!! clean($content->content) !!}</textarea>
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
                                <input type="text" __name__="footer_content_left[__number__][title]" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <textarea __name__="footer_content_left[__number__][content]" class="form-control" rows="5"></textarea>
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
    <label>{{__("Footer content right")}}</label>
    <div class="form-controls">
        <div class="form-group-item">
            <div class="form-group-item">
                <div class="g-items-header">
                    <div class="row">
                        <div class="col-md-5">{{__("Title")}}</div>
                        <div class="col-md-6">{{__('Content')}}</div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="g-items">
                    @php $contents = setting_item('footer_content_right');@endphp
                    @if(!empty($contents))
                        @php $contents = json_decode($contents); @endphp
                        @foreach($contents as $k => $content)
                            <div class="item" data-number="{{$k}}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="text" name="footer_content_right[{{$k}}][title]" class="form-control" value="{{$content->title}}">
                                    </div>
                                    <div class="col-md-6">
                                        <textarea name="footer_content_right[{{$k}}][content]" class="form-control" rows="5">{!! clean($content->content) !!}</textarea>
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
                                <input type="text" __name__="footer_content_right[__number__][title]" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <textarea __name__="footer_content_right[__number__][content]" class="form-control" rows="5"></textarea>
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
