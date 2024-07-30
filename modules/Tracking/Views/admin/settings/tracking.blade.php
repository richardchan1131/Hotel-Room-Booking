@if(is_default_lang())
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Tracking System")}}</h3>
            <p class="form-group-desc">{{__('Config tracking system option')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-title"><strong>{{__("General Options")}}</strong></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Enable Tracking")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="tracking_enable" value="1" @if(setting_item('tracking_enable')) checked @endif> {{__("Yes,please enable it")}} </label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="" >{{__("Do not track these IP address")}}</label>
                        <div class="form-controls">
                            <textarea name="tracking_ignore_ip"  cols="30" rows="10" class="form-control">{{setting_item('tracking_ignore_ip')}}</textarea>
                        </div>
                        <p><i>{{__('Example: 14.232.76.172, 162.158.167.62')}}</i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
