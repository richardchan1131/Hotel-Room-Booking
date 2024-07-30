<?php
$user = auth()->user();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="enquiry_form_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content enquiry_form_modal_form">
            <div class="modal-header">
                <h5 class="modal-title">{{__("Enquiry")}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-0">
                <input type="hidden" name="service_id" value="{{$row->id}}">
                <input type="hidden" name="service_type" value="{{$service_type ?? ''}}">
                <div class="form-input mb-3">
                    <input type="text" value="{{$user->display_name ?? ''}}" name="enquiry_name" >
                    <label class="lh-1 text-16 text-light-1">{{ __("Name *") }}</label>
                </div>
                <div class="form-input mb-3">
                    <input type="text" value="{{$user->email ?? ''}}" name="enquiry_email" >
                    <label class="lh-1 text-16 text-light-1">{{ __("Email *") }}</label>
                </div>
                <div class="form-input mb-3">
                    <input type="text" value="{{$user->phone ?? ''}}" name="enquiry_phone" >
                    <label class="lh-1 text-16 text-light-1">{{ __("Phone") }}</label>
                </div>
                <div class="form-input mb-3" v-if="!enquiry_is_submit">
                    <textarea name="enquiry_note" rows="4"></textarea>
                    <label class="lh-1 text-16 text-light-1">{{ __("Note") }}</label>
                </div>
                @if(setting_item("booking_enquiry_enable_recaptcha"))
                    <div class="form-group">
                        {{recaptcha_field('enquiry_form')}}
                    </div>
                @endif
                <div class="message_box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button -md -blue-1 bg-blue-1-05 text-blue-1" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="button -md -blue-1 bg-dark-3 text-white btn-submit-enquiry">
                    {{__("Send now")}}
                </button>
            </div>
        </div>
    </div>
</div>
