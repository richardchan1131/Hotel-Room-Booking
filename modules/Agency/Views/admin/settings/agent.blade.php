<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Agent Register')}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <div class="form-controls">
                            <div class="form-group">
                                <label> <input type="checkbox" @if($settings['vendor_auto_approved'] ?? '' == 1) checked @endif name="vendor_auto_approved" value="1"> {{__("Agent Auto Approved?")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__('Agent Role')}}</label>
                        <div class="form-controls">
                            <select name="vendor_role" class="form-control">

                                @foreach(\Modules\User\Models\Role::all() as $role)
                                <option value="{{$role->id}}" {{($settings['vendor_role'] ?? '') == $role->id ? 'selected': ''  }}>{{ucfirst($role->name)}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <p>{{__('You can edit on main lang.')}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Agent Profile')}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <div class="form-controls">
                            <div class="form-group">
                                <label> <input type="checkbox" @if($settings['vendor_show_email'] ?? '' == 1) checked @endif name="vendor_show_email" value="1"> {{__("Show agent email in profile?")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-controls">
                            <div class="form-group">
                                <label> <input type="checkbox" @if($settings['vendor_show_phone'] ?? '' == 1) checked @endif name="vendor_show_phone" value="1"> {{__("Show agent phone in profile?")}}</label>
                            </div>
                        </div>
                    </div>
                @else
                    <p>{{__('You can edit on main lang.')}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Content Email Agent Registered')}}</h3>
        <div class="form-group-desc">{{ __('Content email send to Agent or Administrator when user registered.')}}
            @foreach(\Modules\User\Listeners\SendVendorRegisterdEmail::CODE as $item=>$value)
                <div><code>{{$value}}</code></div>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['enable_mail_vendor_registered'] ?? '' == 1) checked @endif name="enable_mail_vendor_registered" value="1"> {{__("Enable send email to customer when customer registered ?")}}</label>
                    </div>
                @else
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['enable_mail_vendor_registered'] ?? '' == 1) checked @endif disabled name="enable_mail_vendor_registered" value="1"> {{__("Enable send email to customer when customer registered ?")}}</label>
                    </div>
                    @if($settings['enable_mail_vendor_registered'] != 1)
                        <p>{{__('You must enable on main lang.')}}</p>
                    @endif
                @endif

                <div class="form-group" data-condition="enable_mail_vendor_registered:is(1)">
                    <label>{{__("Email to agent subject")}}</label>
                    <div class="form-controls">
                        <textarea name="vendor_subject_email_registered" class="form-control" cols="30" rows="2">{{setting_item_with_lang('vendor_subject_email_registered',request()->query('lang'))?? '','New Vendor Registration' }}</textarea>
                    </div>
                </div>
                <div class="form-group" data-condition="enable_mail_vendor_registered:is(1)">
                    <label>{{__("Email to agent content")}}</label>
                    <div class="form-controls">
                        <textarea name="vendor_content_email_registered" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('vendor_content_email_registered',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>


                @if(is_default_lang())
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['admin_enable_mail_vendor_registered'] ?? '' == 1) checked @endif name="admin_enable_mail_vendor_registered" value="1"> {{__("Enable send email to Administrator when customer registered ?")}}</label>
                    </div>
                @else
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['admin_enable_mail_vendor_registered'] ?? '' == 1) checked @endif disabled name="admin_enable_mail_vendor_registered" value="1"> {{__("Enable send email to Administrator when customer registered ?")}}</label>
                    </div>
                    @if($settings['admin_enable_mail_vendor_registered'] != 1)
                        <p>{{__('You must enable on main lang.')}}</p>
                    @endif
                @endif
                <div class="form-group" data-condition="admin_enable_mail_vendor_registered:is(1)">
                    <label>{{__("Email to Administrator subject")}}</label>
                    <div class="form-controls">
                        <textarea name="admin_subject_email_vendor_registered" class="form-control" cols="30" rows="2">{{setting_item_with_lang('admin_subject_email_vendor_registered',request()->query('lang'))?? 'New Vendor Registration' }}</textarea>
                    </div>
                </div>
                <div class="form-group" data-condition="admin_enable_mail_vendor_registered:is(1)">
                    <label>{{__("Email to Administrator content")}}</label>
                    <div class="form-controls">
                        <textarea name="admin_content_email_vendor_registered" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('admin_content_email_vendor_registered',request()->query('lang'))?? '' }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
