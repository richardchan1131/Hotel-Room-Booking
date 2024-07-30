@php  $translation = $row->translate(request()->query('lang',get_main_lang())); @endphp
<input type="hidden" name="gotrip_save_extra" value="1">
<div class="form-group-item">
    <label class="control-label">{{__('General info')}}</label>
    <div class="g-items-header">
        <div class="row">
            <div class="col-md-4">{{__('Title')}}</div>
            <div class="col-md-3">{{__("Desc")}}</div>
            <div class="col-md-3">{{__('Content')}}</div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <div class="g-items">
        @if(!empty($translation->general_info))
            @php if(!is_array($translation->general_info)) $translation->general_info = json_decode($translation->general_info,true); @endphp
            @if(count($translation->general_info))
                @foreach($translation->general_info as $key=>$item)
                    <div class="item" data-number="{{$key}}">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="general_info[{{$key}}][title]" class="form-control" value="{{$item['title'] }}" placeholder="{{__("Title:")}}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="general_info[{{$key}}][desc]" class="form-control" value="{{$item['desc']}}" placeholder="{{__("Desc:")}}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="general_info[{{$key}}][content]" class="form-control" placeholder="{{__("Content:")}}" value="{{$item['content']}}">
                            </div>
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
    <div class="text-right">
        <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
    </div>
    <div class="g-more hide">
        <div class="item" data-number="__number__">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" __name__="general_info[__number__][title]" class="form-control" placeholder="{{__("Title:")}}">
                </div>
                <div class="col-md-4">
                    <input type="text" __name__="general_info[__number__][desc]" class="form-control" placeholder="{{__("Desc:")}}">
                </div>
                <div class="col-md-3">
                    <input type="text" __name__="general_info[__number__][content]" class="form-control" placeholder="{{__("Content:")}}">
                </div>
                <div class="col-md-1">
                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
