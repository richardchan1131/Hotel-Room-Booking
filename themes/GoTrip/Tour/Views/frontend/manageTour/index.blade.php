@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600"> {{!empty($recovery) ?__('Recovery Tours') : __("Manage Tours")}}</h1>
            <div class="text-15 text-light-1">{{ __('Lorem ipsum dolor sit amet, consectetur.') }}</div>
        </div>
        <div class="col-auto">
            @if(Auth::user()->hasPermission('tour_create') && empty($recovery))
                <a href="{{ route("tour.vendor.create") }}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                    {{__("Add Tour")}} <div class="icon-arrow-top-right ml-15"></div>
                </a>
            @endif
        </div>
    </div>
    @include('admin.message')
    @if($rows->total() > 0)
        <div class="bravo-list-item py-30 px-30 rounded-4 bg-white shadow-3">
            <div class="list-item mt-0">
                <div class="row">
                    @foreach($rows as $row)
                        <div class="col-md-12">
                            @include('Tour::frontend.manageTour.loop-list')
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bravo-pagination mt-0 mb-0">
                <span class="count-string">{{ __("Showing :from - :to of :total Tours",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                <div class="mt-2">
                    {{$rows->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    @else
        {{__("No Tours")}}
    @endif
@endsection
