<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Page Search")}}</h3>
        <p class="form-group-desc">{{__('Config page search of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("General Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="property_page_search_title" value="{{setting_item_with_lang('property_page_search_title',request()->query('lang'))}}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="" >{{__("Page list properties layout")}}</label>
                    <div class="form-controls">
                        <select  name="property_page_search_layout" class="form-control">
                            @foreach(config('property.layouts') as $type=>$name)
                                <option value="{{$type}}" {{setting_item('property_page_search_layout') == $type ? 'selected' : ''}}>{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="" >{{__("Display Type")}}</label>
                    <div class="form-controls">
                        <select  name="property_display" class="form-control">
                            @foreach(config('property.displays') as $type=>$name)
                                <option value="{{$type}}" {{setting_item('property_display') == $type ? 'selected' : ''}}>{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @php do_action(\Modules\Property\Hook::PROPERTY_SETTING_AFTER_DISPLAY_TYPE) @endphp
                <div class="form-group">
                    <label class="" >{{__("Page single property layout")}}</label>
                    <div class="form-controls">
                        <select  name="property_page_single_layout" value="{{setting_item_with_lang('property_page_single_layout',request()->query('lang'))}}" class="form-control">
                            <option {{setting_item_with_lang('property_page_single_layout',request()->query('lang')) == 1 ? 'selected="selected"' : ''}} value="1">{{__('V1')}}</option>
                            <option {{setting_item_with_lang('property_page_single_layout',request()->query('lang')) == 2 ? 'selected="selected"' : ''}} value="2">{{__('V2')}}</option>
                            <option {{setting_item_with_lang('property_page_single_layout',request()->query('lang')) == 3 ? 'selected="selected"' : ''}} value="3">{{__('V3')}}</option>
                            <option {{setting_item_with_lang('property_page_single_layout',request()->query('lang')) == 4 ? 'selected="selected"' : ''}} value="4">{{__('V4')}}</option>
                        </select>
                    </div>
                </div>
                @if(is_default_lang())
                    <div class="form-group">
                        <label class="" >{{__("Add prefix Price in Property listing?")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="property_prefix_price_listing" value="1" @if(!empty($settings['property_prefix_price_listing'])) checked @endif /> {{__("Yes, please enable it")}} </label>
                            <br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Open gallery when clicking Featured image on the Listing page?")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="property_thumb_open_gallery" value="1" @if(!empty($settings['property_thumb_open_gallery'])) checked @endif /> {{__("Yes, please enable it")}} </label>
                            <br>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="" >{{__("Layout Map Position")}}</label>
                    <div class="form-controls">
                        <select name="property_layout_map_option" class="form-control">
                            <option {{ (setting_item_with_lang('property_layout_map_option',request()->query('lang')) ?? '') == 'map_left' ? 'selected' : '' }} value="map_left">{{__('Map Left')}}</option>
                            <option {{ (setting_item_with_lang('property_layout_map_option',request()->query('lang')) ?? '') == 'map_right' ? 'selected' : ''  }} value="map_right">{{__("Map Right")}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="" >{{__("Layout Map Size")}}</label>
                    <div class="form-controls">
                        <select name="property_layout_map_size" class="form-control">
                            @foreach(range(4,8) as $size)
                                <option value="{{ (setting_item_with_lang('property_layout_map_size',request()->query('lang')) ?? '') == $size ? 'selected' : '' }}">{{$size}}/12</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>{{__("Map Lat Default")}}</label>
                        <div class="form-controls">
                            <input type="text" name="property_map_lat_default" value="{{$settings['property_map_lat_default'] ?? ''}}" class="form-control" placeholder="21.030513">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>{{__("Map Lng Default")}}</label>
                        <div class="form-controls">
                            <input type="text" name="property_map_lng_default" value="{{$settings['property_map_lng_default'] ?? ''}}" class="form-control" placeholder="105.840565">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>{{__("Map Zoom Default")}}</label>
                        <div class="form-controls">
                            <input type="text" name="property_map_zoom_default" value="{{$settings['property_map_zoom_default'] ?? ''}}" class="form-control" placeholder="13">
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                        <i> {{ __('Get lat - lng in here') }} <a href="https://www.latlong.net" target="_blank">https://www.latlong.net</a></i>
                    </div>
                </div>
            </div>
        </div>
        @include('Property::admin.settings.form-search')
        @include('Property::admin.settings.map-search')
        <div class="panel">
            <div class="panel-title"><strong>{{__("SEO Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <ul class="nav nav-tabs">
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
                    <div class="tab-content" >
                        <div class="tab-pane active" id="seo_1">
                            <div class="form-group" >
                                <label class="control-label">{{__("Seo Title")}}</label>
                                <input type="text" name="property_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('property_page_list_seo_title',request()->query('lang'))}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="property_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('property_page_list_seo_desc',request()->query('lang'))}}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Featured Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('property_page_list_seo_image', $settings['property_page_list_seo_image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        @php
                            $seo_share = json_decode(setting_item_with_lang('property_page_list_seo_desc',request()->query('lang'),'[]'),true);
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="property_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="property_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Facebook Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('property_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="property_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="property_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Twitter Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('property_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(is_default_lang())
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Review Options")}}</h3>
            <p class="form-group-desc">{{__('Config review for property')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Enable review system for Property?")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="property_enable_review" value="1" @if(!empty($settings['property_enable_review'])) checked @endif /> {{__("Yes, please enable it")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("Turn on the mode for reviewing property")}}</small>
                        </div>
                    </div>
                    <div class="form-group" data-condition="property_enable_review:is(1)">
                        <label class="" >{{__("Review must be approval by admin")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="property_review_approved" value="1"  @if(!empty($settings['property_review_approved'])) checked @endif /> {{__("Yes please")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("ON: Review must be approved by admin - OFF: Review is automatically approved")}}</small>
                        </div>
                    </div>
                    <div class="form-group" data-condition="property_enable_review:is(1)">
                        <label class="" >{{__("Review number per page")}}</label>
                        <div class="form-controls">
                            <input type="number" class="form-control" name="property_review_number_per_page" value="{{ $settings['property_review_number_per_page'] ?? 5 }}" />
                            <small class="form-text text-muted">{{__("Break comments into pages")}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(is_default_lang())
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Vendor Options")}}</h3>
            <p class="form-group-desc">{{__('Agent config for property')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Property created by vendor must be approved by admin")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="property_vendor_create_service_must_approved_by_admin" value="1" @if(!empty($settings['property_vendor_create_service_must_approved_by_admin'])) checked @endif /> {{__("Yes please")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("ON: When vendor posts a service, it needs to be approved by administrator")}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

