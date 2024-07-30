<div class="bravo-call-to-action {{$style}}">
    @switch($style)
        @case("style_2")
            @include("Template::frontend.blocks.call-to-action.style-2")
        @break
        @case("style_3")
            @include("Template::frontend.blocks.call-to-action.style-3")
        @break
        @default
            @include("Template::frontend.blocks.call-to-action.style-normal")
    @endswitch
</div>
