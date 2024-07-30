@if(is_default_lang())
    <div class="form-group mt-3">
        <label class="" >{{__("Map Background in Button Show Map")}}</label>
        <div class="form-controls form-group-image">
            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('hotel_map_image',setting_item("hotel_map_image")) !!}
        </div>
    </div>
@endif
