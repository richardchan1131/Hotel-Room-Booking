<div class="form-group">
    <label>{{__("Name")}} <span class="text-danger">*</span></label>
    <input type="text" required value="{{old('title',$translation->title)}}" placeholder="{{__("name")}}" name="title"
           class="form-control">
</div>
<div class="form-group">
    <label>{{__("Description")}} </label>
    <textarea name="content" cols="30" rows="5" class="form-control">{{old('content',$translation->content)}}</textarea>
</div>
<div class="form-group">
    <label>{{__("For Role")}} <span class="text-danger">*</span></label>
    <select name="role_id" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
        @foreach(\Modules\User\Models\Role::all() as $role)
            <option @if(old('role_id',$row->role_id) == $role->id) selected
                    @endif value="{{$role->id}}">{{$role->name}}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="control-label">{{__("Price")}} </label>
    <input type="number" step="any" placeholder="{{__("Free")}}" value="{{old('price',$row->price)}}" name="price"
           class="form-control">
</div>
<div class="form-group">
    <label class="control-label">{{__("Annual Price")}}</label>
    <input type="number" step="any" value="{{old('annual_price',$row->annual_price)}}" name="annual_price"
           class="form-control">
</div>
<div class="form-group">
    <label class="control-label">{{__("Duration")}} <span class="text-danger">*</span></label>
    <input type="number" min="1" value="{{old('duration',max(1,$row->duration))}}" name="duration" class="form-control">
</div>
<div class="form-group">
    <label class="control-label">{{__("Duration Type")}} <span class="text-danger">*</span></label>
    <select name="duration_type" class="form-control" required>
        <option @if(old('duration_type',$row->duration_type) == 'day') selected
                @endif value="day">{{__("Day")}}</option>
        <option @if(old('duration_type',$row->duration_type) == 'week') selected
                @endif value="week">{{__("Week")}}</option>
        <option @if(old('duration_type',$row->duration_type) == 'month') selected
                @endif value="month">{{__("Month")}}</option>
        <option @if(old('duration_type',$row->duration_type) == 'year') selected
                @endif value="year">{{__("Year")}}</option>
    </select>
</div>
<div class="form-group">
    <label class="control-label">{{__("Max Services")}} </label>
    <input type="number" min="0" value="{{old('max_service',$row->max_service)}}" name="max_service"
           placeholder="{{__("Unlimited")}}" class="form-control">
    <p><i>{{__("How many publish services user can post")}}</i></p>
</div>

<div class="form-group">
    <label class="control-label">{{__("Status")}}</label>
    <select name="status" class="form-control">
        <option value="publish">{{__("Publish")}}</option>
        <option @if(old('status',$row->status) == 'draft') selected @endif value="draft">{{__("Draft")}}</option>
    </select>
</div>
@php do_action(\Modules\User\Hook::PLAN_FORM_AFTER_STATUS,$row) @endphp
