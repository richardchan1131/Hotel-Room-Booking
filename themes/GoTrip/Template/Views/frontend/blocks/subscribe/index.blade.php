@switch($style)
    @case('style_2') @include('Template::frontend.blocks.subscribe.style_2') @break
    @case('style_3') @include('Template::frontend.blocks.subscribe.style_3') @break
    @default @include('Template::frontend.blocks.subscribe.style_1')
@endswitch

