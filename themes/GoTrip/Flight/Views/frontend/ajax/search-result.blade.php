<div class="row">
    @if($rows->total() > 0)
        @foreach($rows as $row)
            <div class="col-lg-12">
                @include('Flight::frontend.layouts.search.loop-grid',['wrap_class'=>'item-loop-wrap inner-loop-wrap'])
            </div>
        @endforeach
    @else
        <div class="col-lg-12">
            {{__("Flight not found")}}
        </div>
    @endif
</div>

<div class="bravo-pagination">
    {{$rows->appends(request()->query())->links()}}
    @if($rows->total() > 0)
        <div class="text-center mt-30 md:mt-10">
            <div class="text-14 text-light-1">{{ __("Showing :from - :to of :total flights",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
        </div>
    @endif
</div>
