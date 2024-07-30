<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Permanently delete account")}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Permanently delete account")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    @if(is_default_lang())
                        <div class="form-controls">
                            <label><input type="checkbox" name="user_enable_permanently_delete" value="1" @if(setting_item('user_enable_permanently_delete')) checked @endif > {{__('Yes, please enable it')}}</label>
                        </div>
                        <p>{{__('Permanently delete account will delete all services of that user and that user')}}</p>
                    @else
                        <div class="form-group">
                            <label> <input type="checkbox" @if($settings['user_enable_permanently_delete'] ?? '' == 1) checked @endif disabled name="user_enable_permanently_delete" value="1"> {{__("Yes, please enable it")}}</label>
                        </div>
                        @if($settings['user_enable_permanently_delete'] != 1)
                            <p>{{__('You must enable on main lang.')}}</p>
                        @endif
                    @endif
                </div>
                <div class="form-group" data-condition="user_enable_permanently_delete:is(1)">
                    <label>{{__("Content")}}</label>
                    <div class="form-controls">
                        <textarea name="user_permanently_delete_content" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('user_permanently_delete_content',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>
                <div class="form-group" data-condition="user_enable_permanently_delete:is(1)">
                    <label>{{__("Content confirm")}}</label>
                    <div class="form-controls">
                        <textarea name="user_permanently_delete_content_confirm" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('user_permanently_delete_content_confirm',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Content Email Permanently delete account')}}</h3>
        <div class="form-group-desc">{{ __('Content email verify send when user permanently deleted.')}}
            @foreach(\Modules\User\Emails\UserPermanentlyDelete::CODE as $item=>$value)
                <div><code>{{$value}}</code></div>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['user_enable_permanently_delete_email'] ?? '' == 1) checked @endif name="user_enable_permanently_delete_email" value="1"> {{__("Enable?")}}</label>
                    </div>
                @else
                    <div class="form-group">
                        <label> <input type="checkbox" @if($settings['user_enable_permanently_delete_email'] ?? '' == 1) checked @endif disabled name="user_enable_permanently_delete_email" value="1"> {{__("Enable?")}}</label>
                    </div>
                    @if($settings['user_enable_permanently_delete_email'] != 1)
                        <p>{{__('You must enable on main lang.')}}</p>
                    @endif
                @endif
            </div>
        </div>
        <div class="panel" data-condition="user_enable_permanently_delete_email:is(1)">
            <div class="panel-title"><strong>{{__("To customer")}}</strong></div>
            <div class="panel-body">
                <div class="form-group" >
                    <label>{{__("Subject")}}</label>
                    <div class="form-controls">
                        <input type="text" name="user_permanently_delete_subject_email" class="form-control"  value="{{setting_item_with_lang('user_permanently_delete_subject_email',request()->query('lang')) ?? '' }}">
                    </div>
                </div>
                <div class="form-group" >

                    <label>{{__("Content")}}</label>
                    <div class="form-controls">
                        <textarea name="user_permanently_delete_content_email" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('user_permanently_delete_content_email',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>


            </div>
        </div>
        <div class="panel" data-condition="user_enable_permanently_delete_email:is(1)">
            <div class="panel-title"><strong>{{__("To admin")}}</strong></div>
            <div class="panel-body">
                <div class="form-group" >
                    <label>{{__("Subject")}}</label>
                    <div class="form-controls">
                        <input type="text" name="user_permanently_delete_subject_email_to_admin" class="form-control"  value="{{setting_item_with_lang('user_permanently_delete_subject_email_to_admin',request()->query('lang')) ?? '' }}">
                    </div>
                </div>
                <div class="form-group" >

                    <label>{{__("Content")}}</label>
                    <div class="form-controls">
                        <textarea name="user_permanently_delete_content_email_to_admin" class="d-none has-ckeditor" cols="30" rows="10">{{setting_item_with_lang('user_permanently_delete_content_email_to_admin',request()->query('lang')) ?? '' }}</textarea>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
