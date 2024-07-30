@if(is_default_lang())
    <div class="form-group">
        <label>{{__("Enable Preload")}}</label>
        <div class="form-controls">
            <label><input type="checkbox" @if(setting_item_with_lang('enable_preload',request()->query('lang')) ?? '' == 1) checked @endif name="enable_preload" value="1">{{__('Enable')}}</label>
        </div>
    </div>
    <div class="form-group">
        <label>{{__("Logo Preload")}}</label>
        <div class="form-controls form-group-image">
            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('logo_preload_id',setting_item('logo_preload_id')) !!}
        </div>
    </div>
@endif
