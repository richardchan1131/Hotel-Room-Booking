<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$row->name??''}}" placeholder="{{__("Name")}}" name="name" required class="form-control">
</div>
<div class="form-group">
    <label>{{__("Code")}}</label>
    <input type="text" value="{{$row->code??''}}" placeholder="{{__("IATA Code")}}" name="code" required class="form-control">
</div>
<div class="form-group">
    <label>{{__("Address")}}</label>
    <input type="text" value="{{$row->address??''}}" placeholder="{{__("Address")}}" name="address" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Location")}}</label>
    <select name="location_id" class="form-control">
        <option value="">{{__("-- Please Select --")}}</option>
        <?php
        $traverse = function ($array, $prefix = '') use (&$traverse, $row) {
            foreach ($array as $value) {
                if ($value->id == $row->id) {
                    continue;
                }
                $selected = '';
                if ($row->location_id == $value->id)
                    $selected = 'selected';
                printf("<option value='%s' %s>%s</option>", $value->id, $selected, $prefix . ' ' . $value->name);
                $traverse($value->children, $prefix . '-');
            }
        };
        $traverse($locations);
        ?>
    </select>
</div>
<div class="form-group">
    <label>{{__("Status")}}</label>
    <select class="form-control" name="status">
        <option value="publish">{{__('Publish')}}</option>
        <option value="draft" @if(old('draft',$row->status) == 'draft') selected @endif>{{__("Draft")}}</option>
    </select>
</div>
