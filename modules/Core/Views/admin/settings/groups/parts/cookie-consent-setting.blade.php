<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Cookie consent")}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Cookie consent config")}}</strong></div>
            <div class="panel-body">
                <div class="form-controls">
                    <label><input type="checkbox" @if(setting_item('enable_cookie_consent')) checked @endif name="enable_cookie_consent" value="1">{{ __('Enable Cookie consent') }}</label>
                </div>
                <div class="form-group" data-condition="enable_cookie_consent:is(1)">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#cookiePreferences">{{__("Cookie preferences")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#cookieModal">{{__("Cookie Settings Modal")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div class="tab-pane active" id="cookiePreferences">
                            <div class="form-group">
                                <label>{{__("Cookie Title")}}</label>
                                <div class="form-controls">
                                    <input type="text" name="cookie_consent_preferences_title" value="{{ setting_item('cookie_consent_preferences_title') }}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Primary button Text")}}</label>
                                        <div class="form-controls">
                                            <input type="text" name="cookie_consent_primary_btn_text" value="{{ setting_item('cookie_consent_primary_btn_text',__('Accept all')) }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Primary button Role")}}</label>
                                        <div class="form-controls">
                                            <select name="cookie_consent_primary_btn_role" class="form-control">
                                                <option @if(setting_item('cookie_consent_primary_btn_role') == 'accept_all') selected @endif  value="accept_selected">{{__('Accept all')}}</option>
                                                <option @if(setting_item('cookie_consent_primary_btn_role') == 'accept_selected') selected @endif  value="accept_selected">{{__('Accept selected')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Secondary button Text")}}</label>
                                        <div class="form-controls">
                                            <input type="text" name="cookie_consent_secondary_btn_text" value="{{ setting_item('cookie_consent_secondary_btn_text',__('Settings')) }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Secondary button Role")}}</label>
                                        <div class="form-controls">
                                            <select name="cookie_consent_primary_btn_role" class="form-control">
                                                <option @if(setting_item('cookie_consent_secondary_btn_role') == 'settings') selected @endif  value="settings">{{__('Open modal settings')}}</option>
                                                <option @if(setting_item('cookie_consent_secondary_btn_role') == 'accept_necessary') selected @endif  value="accept_necessary">{{__('Accept necessary')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="cookieModal">
                            <div class="form-group">
                                <label>{{__("Title")}}</label>
                                <div class="form-controls">
                                    <input type="text" name="cookie_consent_setting_modal_title" value="{{ setting_item('cookie_consent_setting_modal_title',__('Cookie preferences')) }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{__("Button save setting text")}}</label>
                                <div class="form-controls">
                                    <input type="text" class="form-control" name="cookie_consent_setting_modal_save" value="{{ setting_item('cookie_consent_setting_modal_save',__('Save settings')) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Button Accept All text")}}</label>
                                        <div class="form-controls">
                                            <input type="text" class="form-control" name="cookie_consent_setting_modal_accept" value="{{ setting_item('cookie_consent_setting_modal_accept',__('Accept All')) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__("Button Reject All text")}}</label>
                                        <div class="form-controls">
                                            <input type="text" class="form-control" name="cookie_consent_setting_modal_reject" value="{{ setting_item('cookie_consent_setting_modal_reject',__('Reject All')) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>{{__("Setting options")}}</label>
                                <div class="form-controls">
                                    <div class="form-group-item">
                                        <div class="form-group-item">
                                            <div class="g-items-header">
                                                <div class="row">
                                                    <div class="col-md-3">{{__("Title")}}</div>
                                                    <div class="col-md-5">{{__('Description')}}</div>
                                                    <div class="col-md-3">{{__('Action')}}</div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                            <div class="g-items">
                                                @php $cookie_consent_setting_modal_block_list = setting_item('cookie_consent_setting_modal_block_list'); @endphp
                                                @if(!empty($cookie_consent_setting_modal_block_list) && is_array(json_decode($cookie_consent_setting_modal_block_list)))
                                                    @foreach(json_decode($cookie_consent_setting_modal_block_list) as $k => $list)
                                                        <div class="item" data-number="{{$k}}">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <input type="text" name="cookie_consent_setting_modal_block_list[{{$k}}][title]" class="form-control" value="{{ $list->title }}">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <textarea name="cookie_consent_setting_modal_block_list[{{$k}}][content]" class="form-control" rows="5" style="height: 100%">{!! $list->content !!}</textarea>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class=""><input type="checkbox" @if(!empty($list->toggle)) checked @endif name="cookie_consent_setting_modal_block_list[{{$k}}][toggle]"> {{ __('Toggle') }}</label>
                                                                    <label class=""><input type="checkbox" @if(!empty($list->enable)) checked @endif name="cookie_consent_setting_modal_block_list[{{$k}}][enable]"> {{ __('Enable') }}</label>
                                                                    <label class=""><input type="checkbox" @if(!empty($list->readonly)) checked @endif name="cookie_consent_setting_modal_block_list[{{$k}}][readonly]"> {{ __('Readonly') }}</label>
                                                                    <label class="mb-0">{{ __('Value') }} <input type="text" name="cookie_consent_setting_modal_block_list[{{$k}}][value]" class="form-control" value="{{ $list->value }}"></label>
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
                                                        <div class="col-md-3">
                                                            <input type="text" __name__="cookie_consent_setting_modal_block_list[__number__][title]" class="form-control" value="">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <textarea __name__="cookie_consent_setting_modal_block_list[__number__][content]" class="form-control" rows="5" style="height: 100%"></textarea>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class=""><input type="checkbox" __name__="cookie_consent_setting_modal_block_list[__number__][toggle]"> {{ __('Toggle') }}</label>
                                                            <label class=""><input type="checkbox" __name__="cookie_consent_setting_modal_block_list[__number__][enable]"> {{ __('Enable') }}</label>
                                                            <label class=""><input type="checkbox" __name__="cookie_consent_setting_modal_block_list[__number__][readonly]"> {{ __('Readonly') }}</label>
                                                            <label class="mb-0">{{ __('Value') }} <input type="text" __name__="cookie_consent_setting_modal_block_list[__number__][value]" class="form-control"></label>
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

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
