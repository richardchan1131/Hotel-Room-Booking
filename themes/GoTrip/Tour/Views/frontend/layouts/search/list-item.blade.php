<!-- Results count and sort -->
<div class="row y-gap-10 items-center justify-between">
    <div class="col-auto">
        <div class="text-18 fw-500 result-count">
            @if($rows->total() > 1)
                {!! __(":count tours found",['count'=>$rows->total()])  !!}
            @else
                {!! __(":count tour found",['count'=>$rows->total()])  !!}
            @endif
        </div>
    </div>

    <div class="col-auto">
        <div class="row x-gap-20 y-gap-20">
            <div class="col-auto bc-form-order">
                @include('Layout::global.search.orderby',['routeName'=>'tour.search'])
            </div>
        </div>
    </div>
</div>

<!--End Filter mobile-->
<div class="ajax-search-result">
    @include('Tour::frontend.ajax.search-result')
</div>

