<?php
$popup = \Modules\Popup\Models\Popup::getActive(request());
if(!$popup) return;
$translation = $popup->translate(request('lang',app()->getLocale()));
?>
<div class="modal bc_popup" tabindex="-1" id="bc_popup_{{$popup->id}}" data-days="{{$popup->expired_days}}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                @if(!empty($translation->title))
                    <h5 class="modal-title mb-2">{{$translation->title}}</h5>
                @endif
                {!! clean($translation->content) !!}
            </div>
        </div>
    </div>
</div>
