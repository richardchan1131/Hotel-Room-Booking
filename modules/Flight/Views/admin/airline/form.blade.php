<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$row->name??''}}" placeholder="{{__("Name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label class="control-label">{{__("Logo")}}</label>
    <div class="form-group-image">
        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id??'') !!}
    </div>
</div>