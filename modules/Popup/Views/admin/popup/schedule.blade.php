<div class="panel">
    <div class="panel-title"><strong>{{__("Schedule")}}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Show every")}}</label>
                    <input type="number" name="schedule_amount" min="1" value="{{old('schedule_amount',$row->schedule_amount)}}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{__("Type")}}</label>
                    <select class="form-control" name="schedule_type">
                        <option value="day" @if($row->schedule_type == 'day') selected @endif >{{__("Day")}}</option>
                        <option value="month" @if($row->schedule_type == 'month') selected @endif >{{__("Month")}}</option>
                        <option value="year" @if($row->schedule_type == 'year') selected @endif >{{__("Year")}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
