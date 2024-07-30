<div class="panel">
    <div class="panel-title"><strong>{{__("Social Info")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <div class="form-controls">
                <div class="form-group-item">
                    <div class="form-group-item">
                        <div class="g-items-header">
                            <div class="row">
                                <div class="col-md-3">{{__("Name social")}}</div>
                                <div class="col-md-4">{{__('Code icon')}}</div>
                                <div class="col-md-4">{{__('Link social')}}</div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <div class="g-items">
                            <?php
                            $social = $row->social;

                            if(!empty($social)) $social = json_decode($social,true);
                            if(empty($social) or !is_array($social))
                                $social = [];
                            ?>
                            @foreach($social as $key=>$item)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="social[{{$key}}][title]" class="form-control" value="{{$item['title']}}">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="social[{{$key}}][code]" class="form-control" value="{{$item['code']}}">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="social[{{$key}}][link]" class="form-control" value="{{$item['link']}}">
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-right">
                            <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                        </div>
                        <div class="g-more hide">
                            <div class="item" data-number="__number__">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" __name__="social[__number__][title]" class="form-control" value="">
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" __name__="social[__number__][code]" class="form-control" value="">
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" __name__="social[__number__][link]" class="form-control" value="">
                                    </div>
                                    <div class="col-md-1">
                                        <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
