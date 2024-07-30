<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("User Plans Options")}}</h3>
        <p class="form-group-desc">{{__('Config user plans page')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">

                @if(is_default_lang())
                    <div class="form-group">
                        <label>{{__("Enable User Plans")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="user_plans_enable" value="1" @if(!empty($settings['user_plans_enable'])) checked @endif /> {{__("On")}} </label>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <label> <input type="checkbox" @if(setting_item('user_plans_enable') ?? '' == 1) checked @endif name="user_plans_enable" disabled value="1"> {{__("On")}}</label>
                    </div>
                    @if(setting_item('user_plans_enable')!= 1)
                        <p>{{__('You must enable on main lang.')}}</p>
                    @endif
                @endif


                <div data-condition="user_plans_enable:is(1)">
                    <div class="form-group">
                        <label>{{__("Page Title")}}</label>
                        <div class="form-controls">
                            <input type="text" name="user_plans_page_title" class="form-control" value="{{setting_item_with_lang('user_plans_page_title',request()->query('lang')) ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("Page Sub Title")}}</label>
                        <div class="form-controls">
                            <input type="text" name="user_plans_page_sub_title" class="form-control" value="{{setting_item_with_lang('user_plans_page_sub_title',request()->query('lang')) ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("Sale Of Text")}}</label>
                        <div class="form-controls">
                            <input type="text" name="user_plans_sale_text" class="form-control" value="{{setting_item_with_lang('user_plans_sale_text',request()->query('lang')) ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("Enable Multi User Plans")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="user_plans_multiple_buy" value="1" @if(!empty($settings['enable_multi_user_plans'])) checked @endif /> {{__("On")}} </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Plan Request options")}}</h3>
        <div class="form-group-desc">{{ __('Content email send to Customer or Administrator.')}}
            @foreach(\Modules\User\Emails\PlanPaymentEmail::CODE as $item=>$value)
                <div><code>{{$value}}</code></div>
            @endforeach
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel" data-condition="user_plans_enable:is(1)">
            <div class="panel-title"><strong>{{__("New request plan")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#NewRequestPlanAdmin">{{__("Administrator")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#NewRequestPlanUser">{{__("Customer")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="NewRequestPlanAdmin">
                            @if(is_default_lang())
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_new_payment_admin_enable')?? '' == 1) checked @endif name="plan_new_payment_admin_enable" value="1"> {{__("Enable send email to Administrator?")}}</label>
                                </div>
                            @else
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_new_payment_admin_enable') ?? '' == 1) checked @endif name="plan_new_payment_admin_enable" disabled value="1"> {{__("Enable send email to Administrator?")}}</label>
                                </div>
                                @if(setting_item('plan_new_payment_admin_enable')!= 1)
                                    <p>{{__('You must enable on main lang.')}}</p>
                                @endif
                            @endif
                            <div data-condition="plan_new_payment_admin_enable:is(1)">
                                <div class="form-group">
                                    <label>{{__("Subject")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_new_payment_admin_subject" rows="8" class="form-control">{{setting_item_with_lang('plan_new_payment_admin_subject',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__("Message")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_new_payment_admin_content" rows="8" class="form-control">{{setting_item_with_lang('plan_new_payment_admin_content',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="NewRequestPlanUser">
                            @if(is_default_lang())
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_new_payment_user_enable')?? '' == 1) checked @endif name="plan_new_payment_user_enable" value="1"> {{__("Enable send email to customer?")}}</label>
                                </div>
                            @else
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_new_payment_user_enable') ?? '' == 1) checked @endif name="plan_new_payment_user_enable" disabled value="1"> {{__("Enable send email to customer?")}}</label>
                                </div>
                                @if(setting_item('plan_new_payment_user_enable')!= 1)
                                    <p>{{__('You must enable on main lang.')}}</p>
                                @endif
                            @endif
                            <div data-condition="plan_new_payment_user_enable:is(1)">
                                <div class="form-group">
                                    <label>{{__("Subject")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_new_payment_user_subject" rows="8" class="form-control">{{setting_item_with_lang('plan_new_payment_user_subject',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__("Message")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_new_payment_user_content" rows="8" class="form-control">{{setting_item_with_lang('plan_new_payment_user_content',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel" data-condition="user_plans_enable:is(1)">
            <div class="panel-title"><strong>{{__("Update request plan")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#UpdateRequestPlanAdmin">{{__("Administrator")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#UpdateRequestPlanUser">{{__("Customer")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="UpdateRequestPlanAdmin">
                            @if(is_default_lang())
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_update_payment_admin_enable')?? '' == 1) checked @endif name="plan_update_payment_admin_enable" value="1"> {{__("Enable send email to Administrator?")}}</label>
                                </div>
                            @else
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_update_payment_admin_enable') ?? '' == 1) checked @endif name="plan_update_payment_admin_enable" disabled value="1"> {{__("Enable send email to Administrator?")}}</label>
                                </div>
                                @if(setting_item('plan_update_payment_admin_enable')!= 1)
                                    <p>{{__('You must enable on main lang.')}}</p>
                                @endif
                            @endif
                            <div data-condition="plan_update_payment_admin_enable:is(1)">
                                <div class="form-group">
                                    <label>{{__("Subject")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_update_payment_admin_subject" rows="8" class="form-control">{{setting_item_with_lang('plan_update_payment_admin_subject',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__("Message")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_update_payment_admin_content" rows="8" class="form-control">{{setting_item_with_lang('plan_update_payment_admin_content',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="UpdateRequestPlanUser">
                            @if(is_default_lang())
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_update_payment_user_enable')?? '' == 1) checked @endif name="plan_update_payment_user_enable" value="1"> {{__("Enable send email to customer?")}}</label>
                                </div>
                            @else
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(setting_item('plan_update_payment_user_enable') ?? '' == 1) checked @endif name="plan_update_payment_user_enable" disabled value="1"> {{__("Enable send email to customer?")}}</label>
                                </div>
                                @if(setting_item('plan_update_payment_user_enable')!= 1)
                                    <p>{{__('You must enable on main lang.')}}</p>
                                @endif
                            @endif
                            <div data-condition="plan_update_payment_user_enable:is(1)">
                                <div class="form-group">
                                    <label>{{__("Subject")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_update_payment_user_subject" rows="8" class="form-control">{{setting_item_with_lang('plan_update_payment_user_subject',request()->query('lang')) ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__("Message")}}</label>
                                    <div class="form-controls">
                                        <textarea name="plan_update_payment_user_content" rows="8" class="form-control">{{setting_item_with_lang('plan_update_payment_user_content',request()->query('lang')) ?? '' }}</textarea>
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
