@if(!empty($booking->coupon_amount) and $booking->coupon_amount > 0)
    <li>
        <div class="label">
            {{__("Coupon")}}
        </div>
        <div class="val">
            -{{ format_money($booking->coupon_amount) }}
        </div>
    </li>
@endif