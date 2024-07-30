<div class="form-group">
    <label>{{ __('Name')}}</label>
    <input type="text" required value="{{$row->name}}" placeholder=" {{ __('Tag name')}}" name="name" class="form-control">
</div>
@if(is_default_lang())
<div class="form-group">
    <label>{{ __('Slug')}}</label>
    <input type="text" value="{{$row->slug}}" placeholder=" {{ __('Tag Slug')}}" name="slug" class="form-control">
</div>
@endif
