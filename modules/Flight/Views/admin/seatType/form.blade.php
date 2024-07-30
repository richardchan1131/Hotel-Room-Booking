<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$row->name??''}}" placeholder="{{__("Name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Code")}}</label>
    <input type="text" value="{{$row->code??''}}" placeholder="{{__("Code")}}" name="code" class="form-control" required>
</div>