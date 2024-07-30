@if(is_default_lang())
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Search Options")}}</h3>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Search open tab")}}</label>
                        <div class="form-controls">
                            <select name="search_open_tab" class="form-control" >
                                <option value="current_tab" {{ setting_item('search_open_tab') == 'current_tab' ? 'selected' : ''  }}>{{__("Current Tab")}}</option>
                                <option value="new_tab" {{ setting_item('search_open_tab') == 'new_tab' ? 'selected' : ''  }}>{{__('Open New Tab')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Square Size Unit")}}</h3>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{__("Size Unit")}}</label>
                        <div class="form-controls">
                            <select name="size_unit" class="form-control" >
                                <option value="m2" {{ setting_item('size_unit') == 'm2' ? 'selected' : ''  }}>{{__("Square metre (m2)")}}</option>
                                <option value="ft" {{setting_item('size_unit') == 'ft' ? 'selected' : ''  }}>{{__('Square feet')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Map Provider")}}</h3>
        <p class="form-group-desc">{{__('Change map provider of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label>{{__("Map Provider")}}</label>
                    <div class="form-controls">
                        <select name="map_provider" class="form-control" >
                            <option value="osm" {{ setting_item('map_provider') == 'osm' ? 'selected' : ''  }}>{{__("OpenStreetMap.org")}}</option>
                            <option value="gmap" {{setting_item('map_provider') == 'gmap' ? 'selected' : ''  }}>{{__('Google Map')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" data-condition="map_provider:is(gmap)">
                    <label>{{__("Gmap API Key")}}</label>
                    <div class="form-controls">
                        <input type="text" name="map_gmap_key" value="{{setting_item('map_gmap_key')}}" class="form-control">
                        <p><i><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="blank">{{__("Learn how to get an api key")}}</a></i></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-title"><strong>{{__('Map Options Default')}}</strong></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>{{__("Map Lat Default")}}</label>
                        <div class="form-controls">
                            <input type="text" name="map_lat_default" value="{{setting_item('map_lat_default')}}" class="form-control" placeholder="21.030513">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>{{__("Map Lng Default")}}</label>
                        <div class="form-controls">
                            <input type="text" name="map_lng_default" value="{{setting_item('map_lng_default')}}" class="form-control" placeholder="105.840565">
                        </div>
                    </div>
                    <div class="col-md-12 mt-1">
                       <i> {{ __('Get lat - lng in here') }} <a href="https://www.latlong.net" target="_blank">https://www.latlong.net</a></i>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>{{__("Map Clustering")}}</label>
                    <div class="form-controls">
                        <select name="map_clustering" class="form-control" >
                            <option value="" {{ setting_item('map_clustering') == '' ? 'selected' : ''  }}>{{__("Off")}}</option>
                            <option value="on" {{setting_item('map_clustering') == 'on' ? 'selected' : ''  }}>{{__('On')}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>{{__("Map fitBounds")}}</label>
                    <div class="form-controls">
                        <select name="map_fit_bounds" class="form-control" >
                            <option value="" {{ setting_item('map_fit_bounds') == '' ? 'selected' : ''  }}>{{__("Off")}}</option>
                            <option value="on" {{setting_item('map_fit_bounds') == 'on' ? 'selected' : ''  }}>{{__('On')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Social Login")}}</h3>
        <p class="form-group-desc">{{__('Change social login information for your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__('Facebook')}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <label> <input type="checkbox" @if(setting_item('facebook_enable') == 1) checked @endif name="facebook_enable" value="1"> {{__("Enable Facebook Login?")}}</label>
                </div>
                <div class="form-group" data-condition="facebook_enable:is(1)">
                    <label>{{__("Facebook Client Id")}}</label>
                    <div class="form-controls">
                        <input type="text" name="facebook_client_id" value="{{setting_item('facebook_client_id')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group" data-condition="facebook_enable:is(1)">
                    <label>{{__("Facebook Client Secret")}}</label>
                    <div class="form-controls">
                        <input type="text" name="facebook_client_secret" value="{{setting_item('facebook_client_secret')}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-title"><strong>{{__('Google')}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <label><input type="checkbox" @if(setting_item('google_enable') == 1) checked @endif name="google_enable" value="1"> {{__("Enable Google Login?")}}</label>
                </div>
                <div class="form-group" data-condition="google_enable:is(1)">
                    <label>{{__("Google Client Id")}}</label>
                    <div class="form-controls">
                        <input type="text" name="google_client_id" value="{{setting_item('google_client_id')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group" data-condition="google_enable:is(1)">
                    <label>{{__("Google Client Secret")}}</label>
                    <div class="form-controls">
                        <input type="text" name="google_client_secret" value="{{setting_item('google_client_secret')}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-title"><strong>{{__('Twitter')}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <label> <input type="checkbox" @if(setting_item('twitter_enable') == 1) checked @endif name="twitter_enable" value="1"> {{__("Enable Twitter Login?")}}</label>
                </div>
                <div class="form-group" data-condition="twitter_enable:is(1)">
                    <label>{{__("Twitter Client Id")}}</label>
                    <div class="form-controls">
                        <input type="text" name="twitter_client_id" value="{{setting_item('twitter_client_id')}}" class="form-control">
                    </div>
                </div>
                <div class="form-group" data-condition="twitter_enable:is(1)">
                    <label>{{__("Twitter Client Secret")}}</label>
                    <div class="form-controls">
                        <input type="text" name="twitter_client_secret" value="{{setting_item('twitter_client_secret')}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Captcha")}}</h3>
        <p class="form-group-desc">{{__('Change map provider of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("ReCaptcha Config")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-controls">
                        <label ><input type="checkbox" @if(setting_item('recaptcha_enable') == 1) checked @endif name="recaptcha_enable" value="1"> {{__("Enable ReCaptcha")}}</label>
                    </div>
                </div>
                <div class="form-group" data-condition="recaptcha_enable:is(1)">
                    <label>{{__("Version")}}</label>
                    <div class="form-controls">
                        <select name="recaptcha_version" id="recaptcha_version" class="form-control">
                            <option value="">{{ __("Version 2") }}</option>
                            <option @if(setting_item('recaptcha_version') =='v3' ) selected @endif value="v3">{{ __("Version 3") }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" data-condition="recaptcha_enable:is(1)">
                    <label>{{__("Api Key")}}</label>
                    <div class="form-controls">
                        <input type="text" name="recaptcha_api_key" value="{{setting_item('recaptcha_api_key')}}" class="form-control">
                        <p><i><a href="http://www.google.com/recaptcha/admin" target="blank">{{__("Learn how to get an api key")}}</a></i></p>
                    </div>
                </div>
                <div class="form-group" data-condition="recaptcha_enable:is(1)">
                    <label>{{__("Api Secret")}}</label>
                    <div class="form-controls">
                        <input type="text" name="recaptcha_api_secret" value="{{setting_item('recaptcha_api_secret')}}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Custom Scripts for all languages")}}</h3>
        <p class="form-group-desc">{{__('Add custom HTML script before and after the content, like tracking code')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Custom Scripts")}}</strong></div>
            <div class="panel-body">
                <div class="form-group" >
                    <label>{{__("Head Script")}}</label>
                    <div class="form-controls">
                        <textarea name="head_scripts"  cols="30" rows="10" class="form-control">{{setting_item('head_scripts')}}</textarea>
                        <p><i>{{__('scripts before closing head tag')}}</i></p>
                    </div>
                </div>
                <div class="form-group" >
                    <label>{{__("Body Script")}}</label>
                    <div class="form-controls">
                        <textarea name="body_scripts"  cols="30" rows="10" class="form-control">{{setting_item('body_scripts')}}</textarea>
                        <p><i>{{__('scripts after open of body tag')}}</i></p>
                    </div>
                </div>
                <div class="form-group" >
                    <label>{{__("Footer Script")}}</label>
                    <div class="form-controls">
                        <textarea name="footer_scripts"  cols="30" rows="10" class="form-control">{{setting_item('footer_scripts')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Custom Scripts for :name",['name'=>request()->query('lang')])}}</h3>
        <p class="form-group-desc">{{__('Add custom HTML script before and after the content, like tracking code')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Custom Scripts")}}</strong></div>
            <div class="panel-body">
                <div class="form-group" >
                    <label>{{__("Head Script")}}</label>
                    <div class="form-controls">
                        <textarea name="head_scripts"  cols="30" rows="10" class="form-control">{{setting_item_with_lang_raw('head_scripts',request()->get('lang'))}}</textarea>
                        <p><i>{{__('scripts before closing head tag')}}</i></p>
                    </div>
                </div>
                <div class="form-group" >
                    <label>{{__("Body Script")}}</label>
                    <div class="form-controls">
                        <textarea name="body_scripts"  cols="30" rows="10" class="form-control">{{setting_item_with_lang_raw('body_scripts',request()->get('lang'))}}</textarea>
                        <p><i>{{__('scripts after open of body tag')}}</i></p>
                    </div>
                </div>
                <div class="form-group" >
                    <label>{{__("Footer Script")}}</label>
                    <div class="form-controls">
                        <textarea name="footer_scripts"  cols="30" rows="10" class="form-control">{{setting_item_with_lang_raw('footer_scripts',request()->get('lang'))}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Cookie agreement")}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Cookie agreement config")}}</strong></div>
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <div class="form-controls">
                            <label ><input type="checkbox" @if(setting_item('cookie_agreement_enable') ?? '' == 1) checked @endif name="cookie_agreement_enable" value="1"> {{__("Enable Cookie agreement")}}</label>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <div class="form-controls">
                            <label ><input type="checkbox" @if(setting_item('cookie_agreement_enable') ?? '' == 1) checked @endif name="cookie_agreement_enable" disabled value="1"> {{__("Enable Cookie agreement")}}</label>
                        </div>
                    </div>
                    @if(setting_item('cookie_agreement_enable') != 1)
                        <p>{{__('You must enable on main lang.')}}</p>
                    @endif
                @endif


                <div class="form-group" data-condition="cookie_agreement_enable:is(1)">
                    <label>{{__("Agree Text Button")}}</label>
                    <div class="form-controls">
                        <input type="text" name="cookie_agreement_button_text" value="{{setting_item_with_lang('cookie_agreement_button_text',request()->query('lang')) ?? ''}}" class="form-control">

                    </div>
                </div>
                <div class="form-group" data-condition="cookie_agreement_enable:is(1)">
                    <label>{{__("Content")}}</label>
                    <div class="form-controls">
                        <textarea name="cookie_agreement_content" rows="8" class="form-control d-none has-ckeditor">{{setting_item_with_lang('cookie_agreement_content',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
@include('Core::admin.settings.groups.parts.cookie-consent-setting')
@include('Core::admin.settings.groups.parts.pusher')
