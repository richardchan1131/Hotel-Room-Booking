<div class="item-list">
    <div class="row">
        <div class="col-md-3">
            <div class="thumb-image">
                <a href="#" target="_blank">
                    @if($row->airline->image_url)
                        <img src="{{$row->airline->image_url}}" class="img-responsive" alt="">
                    @endif
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="item-title">
                <a href="{{$row->getDetailUrl()}}" target="_blank">
                    {{$row->title}}
                </a>
            </div>
            <div class="location">
                @if(!empty($row->airportFrom->name))
                    <i class="fa fa-plane" aria-hidden="true"></i>
                    {{__("Airport From")}}: {{$row->airportFrom->name ?? ''}}
                    <span class="">({{display_datetime($row->departure_time)}})</span>
                @endif
            </div>
            <div class="location">
                @if(!empty($row->airportTo->name))
                    <i class="fa fa-plane fa-rotate-90" aria-hidden="true"></i>
                    {{__("Airport To")}}: {{$row->airportTo->name ?? ''}}
                    <span class="">({{display_datetime($row->arrival_time)}})</span>
                @endif
            </div>
            <div class="location">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                {{__("Duration")}}: <span class="">{{$row->duration??0}}</span>
            </div>
            <div class="location">
                <i class="icofont-ui-settings"></i>
                {{__("Status")}}: <span class="badge badge-{{ $row->status }}">{{ $row->status_text }}</span>
            </div>
            <div class="location">
                <i class="icofont-wall-clock"></i>
                {{__("Last Updated")}}: {{ display_datetime($row->updated_at ?? $row->created_at) }}
            </div>
            <div class="control-action">
                @if(!empty($recovery))
                    <a href="{{ route("flight.vendor.restore",[$row->id]) }}" class="btn btn-recovery btn-primary" data-confirm="{{__('"Do you want to recovery?"')}}">{{__("Recovery")}}</a>
                    @if(Auth::user()->hasPermission('flight_delete'))
                        <a href="{{ route("flight.vendor.delete",['id'=>$row->id,'permanently_delete'=>1]) }}" class="btn btn-danger" data-confirm="<?php echo e(__("Do you want to permanently delete?")); ?>">{{__("Del")}}</a>
                    @endif
                @else
                    @if(Auth::user()->hasPermission('flight_update'))
                        <a href="{{ route("flight.vendor.edit",[$row->id]) }}" class="btn btn-warning">{{__("Edit")}}</a>
                    @endif
                    @if(Auth::user()->hasPermission('flight_delete'))
                        <a href="{{ route("flight.vendor.delete",[$row->id]) }}" class="btn btn-danger" data-confirm="<?php echo e(__("Do you want to delete?")); ?>">{{__("Del")}}</a>
                    @endif
                    @if($row->status == 'publish')
                        <a href="{{ route("flight.vendor.bulk_edit",[$row->id,'action' => "make-hide"]) }}" class="btn btn-secondary">{{__("Make hide")}}</a>
                    @endif
                    @if($row->status == 'draft')
                        <a href="{{ route("flight.vendor.bulk_edit",[$row->id,'action' => "make-publish"]) }}" class="btn btn-success">{{__("Make publish")}}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
