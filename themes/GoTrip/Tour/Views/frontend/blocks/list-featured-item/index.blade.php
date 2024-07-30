@php $style = $style ?? "style1" @endphp
@switch($style)
    @case('style2') @include('Tour::frontend.blocks.list-featured-item.style2') @break
    @case('style3') @include('Tour::frontend.blocks.list-featured-item.style3') @break
    @case('style4') @include('Tour::frontend.blocks.list-featured-item.style4') @break
    @case('style5') @include('Tour::frontend.blocks.list-featured-item.style5') @break
    @case('style6') @include('Tour::frontend.blocks.list-featured-item.style6') @break
    @default @include('Tour::frontend.blocks.list-featured-item.style1')
@endswitch
