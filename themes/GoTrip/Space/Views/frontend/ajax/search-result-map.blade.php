<div class="bravo-list-item @if(!$rows->count()) not-found @endif">

    @if($rows->count())
        <div class="row y-gap-30 pt-20">
            @if($rows->total() > 0)
                @foreach($rows as $row)
                    @if($layout == 'grid')
                        <div class="col-lg-4 col-sm-6">
                            @include('Space::frontend.layouts.search.loop-grid',['wrap_class'=>'item-loop-wrap'])
                        </div>
                    @else
                        <div class="col-12">
                            @include('Space::frontend.layouts.search.loop-item',['wrap_class'=>'item-loop-wrap inner-loop-wrap'])
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-lg-12">
                    {{__("Space not found")}}
                </div>
            @endif
        </div>

        <div class="bravo-pagination">
            {{$rows->appends(request()->except(['_ajax']))->links()}}
            @if($rows->total() > 0)
                <div class="text-center mt-30 md:mt-10">
                    <div class="text-14 text-light-1">{{ __("Showing :from - :to of :total spaces",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
                </div>
            @endif
        </div>
    @else
        <div class="not-found-box">
            <h3 class="n-title">{{__("We couldn't find any spaces.")}}</h3>
            <p class="p-desc">{{__("Try changing your filter criteria")}}</p>

        </div>
    @endif
</div>
