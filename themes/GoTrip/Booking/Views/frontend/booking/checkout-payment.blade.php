<div class="form-section mt-40">
    <h3 class="text-22 fw-500 mb-20">{{__("How do you want to pay?")}}</h3>
    <div class="accordion -simple row y-gap-20 pt-30 js-accordion">
        @foreach($gateways as $k=>$gateway)
            <div class="col-12 accordion__item px-20">
                <div class=" border-light rounded-4 py-20">
                    <div class="accordion__button d-flex items-center">
                        <button class="button text-dark-1 shrink-0  px-20 " type="button">
                            <label class="d-flex items-center" data-toggle="collapse" data-target="#gateway_{{$k}}" >
                                <input type="radio" name="payment_gateway" value="{{$k}}">
                                @if($logo = $gateway->getDisplayLogo())
                                    <img src="{{$logo}}" alt="{{$gateway->getDisplayName()}}">
                                @endif
                                <span class="shrink-0 ml-20">{{$gateway->getDisplayName()}}</span>

                            </label>
                        </button>
                    </div>
                    <div id="gateway_{{$k}}" class="accordion__content" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="pt-20 pl-60">
                            <div class="gateway_name">
                                {!! $gateway->getDisplayName() !!}
                            </div>
                            {!! $gateway->getDisplayHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
