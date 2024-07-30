@if(auth()->check() && $booking->status == 'draft' && empty(setting_item('wallet_module_disable')))
    <hr/>
    <div class="form-group-item">
        <div class="text-20 fw-500 mb-20">{{__("Credit want to pay?")}}</div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text rounded-0">{{__('Credit')}} {{ !empty(auth()->user()) ? auth()->user()->balance : 0  }}</span>
            </div>
            <input type="number" class="form-control deposit_amount" value="0" name="credit">
            <div class="input-group-append">
                <span class="input-group-text convert_deposit_amount">{{format_money(0)}}</span>
            </div>
        </div>
        <div class="d-flex justify-content-between px-24 py-20 rounded-4 bg-green-1"><h5 class="form-section-title">{{__("Pay now")}}:</h5> <div class="val convert_pay_now text-18 lh-13 fw-500">{{format_money(floatval($booking->deposit == null ? $booking->total : $booking->deposit))}}</div></div>
    </div>
@endif
