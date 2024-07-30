@if(is_default_lang())
    <div class="form-group">
        <label>{{__("Logo Dark")}}</label>
        <div class="form-controls form-group-image">
            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('logo_id_dark',setting_item('logo_id_dark')) !!}
        </div>
    </div>
@endif
