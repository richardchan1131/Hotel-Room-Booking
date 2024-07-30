@if(count($car_related) > 0)
    <div class="bravo-list-car-related">
        <div class="row justify-between items-end">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{__("You might also like")}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0"></p>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{route('car.search', ['location_id' => $row->location_id])}}" class="button h-50 px-24 -blue-1 bg-blue-1-05 text-blue-1">
                    {{__('See All')}} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            </div>
        </div>
        <div class="row">
            @foreach($car_related as $k=>$item)
                <div class="col-md-3">
                    @include('Car::frontend.layouts.search.loop-grid',['row'=>$item,'include_param'=>0])
                </div>
            @endforeach
        </div>
    </div>
@endif
