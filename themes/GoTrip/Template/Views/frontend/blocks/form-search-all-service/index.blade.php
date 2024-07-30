@switch($style)
    @case('carousel') @include("Template::frontend.blocks.form-search-all-service.style-normal") @break
    @case('carousel_v2') @include("Template::frontend.blocks.form-search-all-service.carousel_v2") @break
    @case('carousel_v3') @include("Template::frontend.blocks.form-search-all-service.carousel_v3") @break
    @case('normal2') @include("Template::frontend.blocks.form-search-all-service.style-normal-2") @break
    @default @include("Template::frontend.blocks.form-search-all-service.style-normal")
@endswitch
