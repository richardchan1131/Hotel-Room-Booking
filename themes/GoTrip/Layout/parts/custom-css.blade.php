@php $main_color = setting_item('style_main_color','#3554D1');
$style_typo = json_decode(setting_item_with_lang('style_typo',false,"{}"),true);
@endphp

    body{
    @if(!empty($style_typo) && is_array($style_typo))
        @foreach($style_typo as $k=>$v)
            @if($v)
                {{str_replace('_','-',$k)}}:{!! $v !!};
            @endif
        @endforeach
    @endif
    }
    @if(!empty($main_color))
        /*----------main color------------*/
        .text-blue-1,
        .header .header-menu .menu .subnav > li > a:hover,
        .bravo_wrap .footer .menu-footer .menu__nav li .subnav > li > a:hover,
        .desktopMenu .menu a:hover,
        .desktopMenu .menu .subnav__backBtn a,
        .hotel_rooms_form .nav-enquiry .enquiry-item.active span,
        .bravo_single_book .nav-enquiry .enquiry-item.active span,
        .pricing-table .title{
            color: {{ $main_color }};
        }

        .tabs.-underline .tabs__controls .tabs__button:hover,
        .tabs.-pills-2 .tabs__controls .tabs__button:hover,
        .tabs.-bookmark-2 .tabs__button:hover,
        .sidebar.-dashboard .sidebar__button.-is-active,
        .tabs.-underline-2 .tabs__controls .tabs__button.is-tab-el-active,
        .accordion.-db-sidebar .accordion__item.is-active .sidebar__button,
        .tabs.-underline-2 .tabs__controls .tabs__button:hover{
            color: {{ $main_color }} !important;
        }

        .pagination.-dots .pagination__item.is-active,
        .button.-outline-blue-1:hover,
        .form-checkbox:hover input ~ .form-checkbox__mark,
        .pricing-tabs .tab-btns:before,
        .tabs.-underline-2 .tabs__controls .tabs__button::after{
            background-color: {{ $main_color }};
        }

        .bg-blue-1,
        .button.-blue-1:hover,
        .tabs.-pills-2 .tabs__controls .tabs__button.is-tab-el-active,
        .tourTypeCard.-type-1:hover,
        .noUi-connect,
        .accordion.-map .accordion__item.is-active .accordion__icon,
        .form-checkbox input:checked ~ .form-checkbox__mark{
            background-color: {{ $main_color }} !important;
        }

        .button.-blue-1:hover,
        .border-blue-1,
        .button.-outline-blue-1,
        .noUi-handle,
        .hotel_rooms_form .nav-enquiry .enquiry-item.active span,
        .bravo_single_book .nav-enquiry .enquiry-item.active span,
        .form-checkbox input:checked ~ .form-checkbox__mark,
        .pricing-table .inner-box:hover, .pricing-table.tagged .inner-box{
            border-color: {{ $main_color }};
        }
        /*-----------end main color------------*/
    @endif

    @if(!empty($style_h1_font_family = setting_item_with_lang("style_h1_font_family") ))
        h1{
            font-family: {{ $style_h1_font_family }}, sans-serif
        }
    @endif
    @if(!empty($style_h2_font_family = setting_item_with_lang("style_h2_font_family") ))
        h2{
            font-family: {{ $style_h2_font_family }}, sans-serif
        }
    @endif
    @if(!empty($style_h3_font_family = setting_item_with_lang("style_h3_font_family") ))
        h3{
            font-family: {{ $style_h3_font_family }}, sans-serif
        }
    @endif

    {!! (setting_item('style_custom_css')) !!}
    {!! (setting_item_with_lang_raw('style_custom_css')) !!}
