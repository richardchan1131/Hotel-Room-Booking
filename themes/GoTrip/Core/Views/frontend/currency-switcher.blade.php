@php
    $actives = \App\Currency::getActiveCurrency();
    $current = \App\Currency::getCurrent('currency_main');
@endphp
{{--Multi Language--}}
@if(!empty($actives) and count($actives) > 1)
    <li class="currency-dropdown menu-item-has-children">
        @foreach($actives as $currency)
            @if($current == $currency['currency_main'])
                <a href="#" class="is_login">
                    <span class="mr-10">{{strtoupper($currency['currency_main'])}}</span>
                    <i class="icon icon-chevron-sm-down"></i>
                </a>
            @endif
        @endforeach
        <ul class="subnav">
            @foreach($actives as $currency)
                @if($current != $currency['currency_main'])
                    <li>
                        <a href="{{get_currency_switcher_url($currency['currency_main'])}}" class="is_login dropdown-item">
                            {{strtoupper($currency['currency_main'])}}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@endif
{{--End Multi language--}}
