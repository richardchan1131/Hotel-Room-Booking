<div class="bravo-call-to-action {{$style}}">
    @switch($style)
        @case("style_2")
            @include("Tour::frontend.blocks.call-to-action.style-2")
        @break
       {{-- @case("style_3")
            @include("Tour::frontend.blocks.call-to-action.style-3")
        @break--}}
        @case("style_4")
            @include("Tour::frontend.blocks.call-to-action.style-4")
        @break
        @case("style_5")
            @include("Tour::frontend.blocks.call-to-action.style-5")
        @break
        @default
            @include("Tour::frontend.blocks.call-to-action.style-normal")
    @endswitch
</div>
