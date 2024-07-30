@if($row->getGallery())
    @include('Layout::common.detail.gallery5',['galleries' => $row->getGallery()])
@endif
<div class="row x-gap-80 y-gap-40 pt-40">
    <div class="col-12 gotrip-overview">
        <h3 class="text-22 fw-500">{{ __("Overview") }}</h3>
        <div class="text-dark-1 text-15 mt-20">
            {!! clean($translation->content) !!}
        </div>
    </div>
    @include('Boat::frontend.layouts.details.specs')
    @include('Boat::frontend.layouts.details.attributes')
</div>
