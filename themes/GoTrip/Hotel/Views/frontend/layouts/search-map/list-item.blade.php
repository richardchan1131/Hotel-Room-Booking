<div class="bravo-list-item">
    <div class="row y-gap-10 justify-between items-center pb-20 topbar-search">
        <div class="col-auto">
            <h2 class="text-18">
                <span class="fw-500">
                    @if($rows->total() > 1)
                        {{ __(":count hotels found",['count'=>$rows->total()]) }}
                    @else
                        {{ __(":count hotel found",['count'=>$rows->total()]) }}
                    @endif
                </span>
            </h2>
        </div>
        <div class="col-auto">
            <div class="control d-flex align-items-center">
                @include('Hotel::frontend.layouts.search-map.orderby')
            </div>
        </div>
    </div>

    <div class="row y-gap-20 list-service-item">
        @if($rows->total() > 0)
            @foreach($rows as $row)
                <div class="item col-12">
                    <div class="border-top-light pt-20">
                        @include('Hotel::frontend.layouts.search.loop-list')
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-lg-12">
                {{__("Hotel not found")}}
            </div>
        @endif
    </div>

    <div class="goTrip-bravo-pagination">
        {{$rows->appends(request()->query())->links()}}
        @if($rows->total() > 0)
            <div class="text-center mt-30 md:mt-10">
                <div class="text-14 text-light-1">
                    {{ __("Showing :from - :to of :total Hotels",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}
                </div>
            </div>
        @endif
    </div>
</div>
