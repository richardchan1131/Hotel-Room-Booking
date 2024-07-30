@php
    $footerStyle = !empty($row->footer_style) ? $row->footer_style : setting_item('footer_style','normal');
    $footer_classes = "-type-1";
    if($footerStyle == "style_1"){
        $footer_classes = "-type-1 text-white bg-dark-2";
    }
    if($footerStyle == "style_2"){
        $footer_classes = "-type-2 bg-light-2";
    }
    if($footerStyle == "style_3"){
        $footer_classes = "-type-3 text-white bg-dark-1";
    }
    if($footerStyle == "style_4"){
        $footer_classes = "-type-2 bg-blue-1 text-white";
    }
    if($footerStyle == "style_5"){
        $footer_classes = "-type-2 bg-dark-2 text-white";
    }
    if($footerStyle == "style_6"){
        $footer_classes = "-type-1 text-white bg-blue-1";
    }
	if($footerStyle == "style_7"){
        $footer_classes = "-type-2 bg-light-2 text-dark";
    }
    if($footerStyle == "style_8"){
        $footer_classes = "footer -type-2 bg-dark-3 text-white";
    }
@endphp

<div class="footer {{ $footer_classes }} {{$footerStyle}}">
    <div class="container">
        @switch($footerStyle)
            @case('style_4')
            @case('style_5') @include('Layout::parts.footer-style.style_4') @break
            @case('style_7') @include('Layout::parts.footer-style.style_7') @break
            @case('style_8') @include('Layout::parts.footer-style.style_4',['logoStyle' => 'light']) @break
            @default @include('Layout::parts.footer-style.normal')
        @endswitch

        <section class="footer_middle_area py-20 @if($footerStyle == 'style_1') border-top-white-15 @else border-top-light @endif">
            <div class="row justify-between items-center y-gap-10">
                <div class="col-auto">
                    {!! setting_item_with_lang("footer_text_left") ?? ''  !!}
                </div>
                <div class="col-auto">
                    <div class="row y-gap-10 items-center">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="menu-footer">
                                    <div class="mobile-overlay"></div>
                                    <div class="header-menu__content">
                                        <div class="menu js-navList">
                                            <ul class="menu__nav -is-active">
                                                @include('Core::frontend.currency-switcher')
                                                @include('Language::frontend.switcher-dropdown')
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            {!! setting_item_with_lang("footer_text_right") ?? ''  !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
