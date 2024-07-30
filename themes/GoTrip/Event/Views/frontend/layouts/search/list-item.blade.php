<!-- Results count and sort -->
<div class="row y-gap-10 items-center justify-between">
    <div class="col-auto">
        <div class="text-18 fw-500 result-count">
            @if($rows->total() > 1)
                {!! __(":count events found",['count'=>$rows->total()])  !!}
            @else
                {!! __(":count event found",['count'=>$rows->total()])  !!}
            @endif
        </div>
    </div>

    <div class="col-auto">
        <div class="row x-gap-20 y-gap-20">
            <div class="col-auto bc-form-order">
                @include('Layout::global.search.orderby',['routeName'=>'event.search'])
            </div>
        </div>
    </div>
</div>
<!-- End Results count and sort -->

<div class="ajax-search-result">
    @include('Event::frontend.ajax.search-result')
</div>

