<div class="panel">
    <div class="panel-title"><strong>{{__("Show on")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label>{{__("Include URLs")}}</label>
            <div class="form-controls">
                <div class="form-group-item g-simple">
                    <div class="g-items">
                        @php
                            $old = $row->include_url;
                        @endphp
                        @if(!empty($old))
                            @foreach($old as $key=>$item)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >{{url('/')}}/</span>
                                                </div>
                                                <input type="text" name="include_url[{{$key}}][url]" value="{{$item['url'] ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                    </div>
                    <div class="g-more hide">
                        <div class="item" data-number="__number__">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >{{url('/')}}/</span>
                                        </div>
                                        <input type="text" __name__="include_url[__number__][url]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p><i>{{__("Wildcard allowed. Eg: */checkout/* ")}}</i></p>
        </div>
        <hr>
        <div class="form-group">
            <label>{{__("Exclude URLs")}}</label>
            <div class="form-controls">
                <div class="form-group-item g-simple">
                    <div class="g-items">
                        @php
                            $old = $row->exclude_url;
                        @endphp
                        @if(!empty($old))
                            @foreach($old as $key=>$item)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" >{{url('/')}}/</span>
                                                </div>
                                                <input type="text" name="exclude_url[{{$key}}][url]" value="{{$item['url'] ?? ''}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                    </div>
                    <div class="g-more hide">
                        <div class="item" data-number="__number__">
                            <div class="row">
                                <div class="col-md-11">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >{{url('/')}}/</span>
                                        </div>
                                        <input type="text" __name__="exclude_url[__number__][url]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p><i>{{__("Wildcard allowed. Eg: */checkout/* ")}}</i></p>
        </div>
    </div>
</div>
