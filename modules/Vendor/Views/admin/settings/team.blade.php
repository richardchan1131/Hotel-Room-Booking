<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__('Team Members')}}</h3>
        <p class="form-group-desc">{{__('Change your config vendor team members')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                @if(is_default_lang())
                    <div class="form-group">
                        <div class="form-controls">
                            <div class="form-group">
                                <label> <input type="checkbox" @if(setting_item('vendor_team_enable')) checked @endif name="vendor_team_enable" value="1"> {{__("Team Member enable?")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-controls">
                            <div class="form-group">
                                <label> <input type="checkbox" @if(setting_item('vendor_team_auto_approved')) checked @endif name="vendor_team_auto_approved" value="1"> {{__("Auto-approve team member request?")}}</label>
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
