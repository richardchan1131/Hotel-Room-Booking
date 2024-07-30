@if(is_default_lang())
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("General Options")}}</h3>
    </div>
    <div class="col-md-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("General Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group" >
                    <label class="" >{{__("Allow customer upload picture to review")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="review_upload_picture" value="1"  @if(!empty(setting_item('review_upload_picture'))) checked @endif /> {{__("Yes please")}} </label>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
