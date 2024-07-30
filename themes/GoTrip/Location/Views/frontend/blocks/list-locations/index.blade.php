@switch($layout)
    @case('style_2') @include('Location::frontend.blocks.list-locations.style_2') @break
    @case('style_3') @include('Location::frontend.blocks.list-locations.style_3') @break
    @case('style_4') @include('Location::frontend.blocks.list-locations.style_4') @break
    @case('style_5') @include('Location::frontend.blocks.list-locations.style_5') @break
    @case('style_6') @include('Location::frontend.blocks.list-locations.style_6') @break
    @case('style_7') @include('Location::frontend.blocks.list-locations.style_7') @break
    @case('style_8') @include('Location::frontend.blocks.list-locations.style_8') @break
    @case('style_9') @include('Location::frontend.blocks.list-locations.style_9') @break
    @case('style_10') @include('Location::frontend.blocks.list-locations.style_10') @break
    @default @include('Location::frontend.blocks.list-locations.default')
@endswitch
