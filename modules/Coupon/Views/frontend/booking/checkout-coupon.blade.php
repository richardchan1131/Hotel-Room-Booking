<li class="d-flex flex-column border-0 mb-0">
    <div class="section-coupon-form">
        @if(in_array($booking->status , ['draft']))
            <div class="input-group group-form mb-3">
                <input type="text" class="form-control" name="coupon_code" placeholder="{{ __("Coupon code") }}">
                <div class="input-group-append">
                    <button class="btn btn-primary bravo_apply_coupon" type="button">
                        {{__("Apply")}}
                        <i class="fa fa-spin fa-spinner d-none"></i>
                    </button>
                </div>
            </div>
        @endif
        @if(!empty($booking->coupons))
            <ul class="p-0 mb-3 list-coupons">
                @foreach($booking->coupons as $item)
                    <li class="item">
                        <div class="label">
                            {{ $item->coupon_data['code'] }}
                            <i data-toggle="tooltip" data-placement="top" class="icofont-info-circle" data-original-title="{{ $item->coupon_data['name'] }}"></i>
                        </div>
                        <div class="val">
                            -{{ format_money( $item->coupon_amount ) }}
                            @if(in_array($booking->status , ['draft']))
                                <a href="#" data-code="{{ $item->coupon_code }}" class="text-danger text-decoration-none bravo_remove_coupon">
                                {{ __("[Remove]") }}
                                <i class="fa fa-spin fa-spinner d-none"></i>
                            </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="message alert-text mt-2"></div>
    </div>
</li>