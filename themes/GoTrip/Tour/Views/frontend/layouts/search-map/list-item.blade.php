<div class="bravo-list-item">
    <div class="row y-gap-10 justify-between items-center pt-0">
        <div class="col-auto">
            <div class="text-18">
            <span class="fw-500">
                @if($rows->total() > 1)
                    {{ __(":count tours found",['count'=>$rows->total()]) }}
                @else
                    {{ __(":count tour found",['count'=>$rows->total()]) }}
                @endif
            </span>
            </div>
        </div>

        <div class="col-auto">
            @include('Tour::frontend.layouts.search-map.orderby')
        </div>
    </div>
    <div class="row y-gap-30 pt-20">

        @if($rows->total() > 0)
            @foreach($rows as $row)
                <div class="item col-12">
                    @include('Tour::frontend.layouts.search.loop-list')
                </div>
            @endforeach
        @else
            <div class="col-lg-12">
                {{__("Tour not found")}}
            </div>
        @endif

    </div>
    <div class="goTrip-bravo-pagination">
        {{$rows->appends(request()->query())->links()}}
        @if($rows->total() > 0)
            <div class="text-center mt-30 md:mt-10">
                <div class="text-14 text-light-1">
                    {{ __("Showing :from - :to of :total tours",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}
                </div>
            </div>
        @endif
    </div>
</div>
