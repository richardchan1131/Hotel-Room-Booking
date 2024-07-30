@switch($style)
    @case('style_2') @include('Tour::frontend.blocks.testimonial.style_2') @break
    @case('style_3') @include('Tour::frontend.blocks.testimonial.style_3') @break
    @case('style_4') @include('Tour::frontend.blocks.testimonial.style_4') @break
    @case('style_5') @include('Tour::frontend.blocks.testimonial.style_5') @break
    @case('style_6') @include('Tour::frontend.blocks.testimonial.style_6') @break
    @case('style_7') @include('Tour::frontend.blocks.testimonial.style_7') @break
    @case('style_8') @include('Tour::frontend.blocks.testimonial.style_8') @break
    @default @include('Tour::frontend.blocks.testimonial.style_1')
@endswitch
