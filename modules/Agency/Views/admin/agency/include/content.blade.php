<div class="panel">
    <div class="panel-title"><strong>{{__("Agency Content")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label>{{__("Name")}}</label>
            <input type="text" value="{{ old('name',$translation->name) }}" placeholder="{{__("Agency name")}}" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Content")}}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{ old('content',$translation->content) }}</textarea>
            </div>
        </div>
        @if(is_default_lang())
        <div class="row form-group">
            <div class="col-md-6 col-sm-12">
                <label class="control-label">{{__("Office")}}</label>
                <input type="text" name="office" class="form-control" value="{{ $row->office ? $row->office : old('office') }}" placeholder="{{__("Office")}}">
            </div>
            <div class="col-md-6 col-sm-12">
                <label class="control-label">{{__("Mobile")}}</label>
                <input type="text" name="mobile" class="form-control" value="{{ $row->mobile ? $row->mobile : old('mobile') }}" placeholder="{{__("Mobile")}}">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6 col-sm-12">
                <label class="control-label">{{__("Email")}}</label>
                <input type="text" name="email" class="form-control" value="{{ $row->email ? $row->email : old('email') }}" placeholder="{{__("Email")}}">
            </div>
            <div class="col-md-6 col-sm-12">
                <label class="control-label">{{__("Fax")}}</label>
                <input type="text" name="fax" class="form-control" value="{{ $row->fax ? $row->fax : old('fax') }}" placeholder="{{__("Fax")}}">
            </div>
        </div>
        @endif

        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Banner Image")}}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id',$row->banner_image_id) !!}
                </div>
            </div>
        @endif
    </div>
</div>
@if(is_default_lang())
    @include('Agency::admin.agency.include.social')
@endif
