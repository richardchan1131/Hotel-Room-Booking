<div class="bravo-list-tour {{$style_list}}">
    @if($style_list == 'normal')
        @include("Tour::frontend.blocks.list-tour.style-normal")
    @endif
    @if($style_list == "carousel")
        @include("Tour::frontend.blocks.list-tour.style-carousel")
    @endif
</div>
