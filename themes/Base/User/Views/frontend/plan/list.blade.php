<div class="sec-title text-center">
    <h2>{{ setting_item_with_lang('user_plans_page_title', app()->getLocale()) ?? __("Pricing Packages")}}</h2>
    <div class="text">{{ setting_item_with_lang('user_plans_page_sub_title', app()->getLocale()) ?? __("Choose your pricing plan") }}</div>
</div>
<div class="pricing-tabs tabs-box">
    <div class="tab-buttons">
        <h4>{{ setting_item_with_lang('user_plans_sale_text', app()->getLocale()) ?? __('Save up to 10%') }}</h4>
        <ul class="tab-btns">
            <li data-tab="#monthly" class="tab-btn active-btn">{{__('Monthly')}}</li>
            <li data-tab="#annual" class="tab-btn">{{__('Annual')}}</li>
        </ul>
    </div>
    <div class="tabs-content">
        <div class="tab active-tab" id="monthly">
            <div class="content">
                <div class="row">
                    @foreach($plans as $plan)
                        @php
                            $translate = $plan->translate();
                        @endphp
                        <div class="pricing-table col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                @if($plan->is_recommended)
                                    <span class="tag">{{__('Recommended')}}</span>
                                @endif
                                <div class="title">{{$translate->title}}</div>
                                <div class="price">{{$plan->price ? format_money($plan->price) : __('Free')}}
                                    @if($plan->price)
                                    <span class="duration">/ {{$plan->duration > 1 ? $plan->duration : ''}} {{$plan->duration_type_text}}</span>
                                    @endif
                                </div>
                                <div class="table-content">
                                    {!! clean($translate->content) !!}
                                </div>
                                <div class="table-footer">
                                    @if($user and $user_plan = $user->user_plan and $user_plan->plan_id == $plan->id)
                                        @if($user_plan->is_valid)
                                            <div class="d-flex text-center">
                                                <a href="{{ route('user.plan') }}" class="theme-btn btn-style-one mr-2">{{__("Current Plan")}}</a>
                                                @if(setting_item_with_lang('enable_multi_user_plans'))
                                                    <a href="{{route('user.plan.buy',['id'=>$plan->id])}}" class="btn btn-warning">{{__('Repurchase')}}</a>
                                                @endif
                                            </div>
                                        @else
                                            <a href="{{route('user.plan.buy',['id'=>$plan->id])}}" class="btn btn-warning">{{__('Repurchase')}}</a>
                                        @endif
                                    @else
                                        <a href="{{route('user.plan.buy',['id'=>$plan->id])}}" class="btn btn-primary">{{__('Select')}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab" id="annual">
            <div class="content">
                <div class="row">
                    @foreach($plans as $plan)
                        <?php if(!$plan->annual_price) continue;?>
                        <div class="pricing-table col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                @if($plan->is_recommended)
                                    <span class="tag">{{__('Recommended')}}</span>
                                @endif
                                <div class="title">{{$plan->title}}</div>
                                <div class="price">{{format_money($plan->annual_price)}} <span class="duration">/ {{__("year")}}</span></div>
                                <div class="table-content">
                                    {!! clean($plan->content) !!}
                                </div>
                                <div class="table-footer">
                                    @if($user and $user_plan = $user->user_plan and $user_plan->plan_id == $plan->id)
                                        @if($user_plan->is_valid)
                                            <div class="d-flex text-center">
                                                <a href="{{ route('user.plan') }}" class="theme-btn btn-style-one mr-2">{{__("Current Plan")}}</a>
                                                @if(setting_item_with_lang('enable_multi_user_plans'))
                                                    <a href="{{route('user.plan.buy',['id'=>$plan->id])}}" class="btn btn-warning">{{__('Repurchase')}}</a>
                                                @endif
                                            </div>
                                        @else
                                            <a href="{{route('user.plan.buy',['id'=>$plan->id,'annual'=>1])}}" class="btn btn-warning">{{__('Repurchase')}}</a>
                                        @endif
                                    @else
                                        <a href="{{route('user.plan.buy',['id'=>$plan->id,'annual'=>1])}}" class="btn btn-primary">{{__('Select')}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
