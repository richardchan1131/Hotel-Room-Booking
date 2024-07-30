@switch($style ?? '')
    @case('style_2') @include("Template::frontend.blocks.download.style_2") @break
    @case('style_4') @include("Template::frontend.blocks.download.style_4") @break
    @default @include("Template::frontend.blocks.download.style_1")
@endswitch
