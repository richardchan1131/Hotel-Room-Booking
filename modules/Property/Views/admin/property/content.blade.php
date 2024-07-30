<div class="panel">
    <div class="panel-title"><strong>{{__("Property Content")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label>{{__("Title")}}</label>
            <input type="text" value="{{$translation->title}}" placeholder="{{__("Name of the property")}}" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Content")}}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
            </div>
        </div>

        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Youtube Video")}}</label>
                <input type="text" name="video" class="form-control" value="{{$row->video}}" placeholder="{{__("Youtube link video")}}">
            </div>
        @endif
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Video Background")}}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id',$row->banner_image_id) !!}
                </div>
            </div>
        @endif
        @if(is_default_lang())
            <div class="panel">
                <div class="panel-title"><strong>{{__("Gallery")}}</strong></div>
                <div class="panel-body">
                    {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
                </div>
            </div>
        @endif
    </div>
</div>

@include('Property::admin.property.pricing')
@if(is_default_lang())
<div class="panel">
    <div class="panel-title"><strong>{{__("Extra Info")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("No. Bed")}}</label>
                    <input type="number" value="{{$row->bed}}" placeholder="{{__("Example: 3")}}" name="bed" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("No. Bathroom")}}</label>
                    <input type="number" value="{{$row->bathroom}}" placeholder="{{__("Example: 5")}}" name="bathroom" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Square")}}</label>
                    <input type="number" value="{{$row->square}}" placeholder="{{__("Example: 100")}}" name="square" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Garages")}}</label>
                    <input type="number" value="{{$row->garages}}" placeholder="{{__("Example: 100")}}" name="garages" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Year built")}}</label>
                    <input type="number" value="{{$row->year_built}}" placeholder="{{__("Example: 2020")}}" name="year_built" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Area")}}</label>
                    <input type="number" value="{{$row->area}}" placeholder="{{__("Example: 100")}}" name="area" class="form-control" min="0">
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(is_default_lang())
<div class="panel">
    <div class="panel-title"><strong>{{__("Additional details")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Deposit")}}</label>
                    <input type="text" value="{{$row->deposit}}" name="deposit" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Pool size")}}</label>
                    <input type="text" value="{{$row->pool_size}}" name="pool_size" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Additional zoom")}}</label>
                    <input type="text" value="{{$row->additional_zoom}}"  name="additional_zoom" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Remodal year")}}</label>
                    <input type="number" value="{{$row->remodal_year}}" name="remodal_year" class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Amenities")}}</label>
                    <input type="text" value="{{$row->amenities}}" name="amenities" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{__("Equipment")}}</label>
                    <input type="text" value="{{$row->equipment}}" name="equipment" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>
@endif

