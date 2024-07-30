<!-- Results count and sort -->
<div class="row y-gap-10 items-center justify-between">
    <div class="col-auto">
        <div class="text-18 fw-500 result-count">
            @if($rows->total() > 1)
                {!! __(":count boats found",['count'=>$rows->total()])  !!}
            @else
                {!! __(":count boat found",['count'=>$rows->total()])  !!}
            @endif
        </div>
    </div>

    <div class="col-auto">
        <div class="row x-gap-20 y-gap-20">
            <div class="col-auto bc-form-order">
                @include('Layout::global.search.orderby',['routeName'=>'boat.search'])
            </div>
        </div>
    </div>
</div>
<!-- End Results count and sort -->

@if(is_mobile())
<!--Filter mobile-->
<div class="filterPopup bg-white" data-x="filterPopup" data-x-toggle="-is-active">
    <aside class="sidebar -mobile-filter">
        <div data-x-click="filterPopup" class="-icon-close">
            <i class="icon-close"></i>
        </div>

        @include('Boat::frontend.layouts.search.sidebar-form-search', ['layout' => $layout])
        <!-- Mobile form -->
    </aside>
</div>
@endif

<!--End Filter mobile-->
<div class="ajax-search-result">
    @include('Boat::frontend.ajax.search-result')
</div>

