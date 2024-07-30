@extends('layouts.user')
@section('content')
    <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
        <div class="col-auto">
            <h1 class="text-30 lh-14 fw-600">{{__("WishList")}}</h1>
            <div class="text-15 text-light-1">{{ __("Lorem ipsum dolor sit amet, consectetur.") }}</div>
        </div>
        <div class="col-auto"></div>
    </div>
    @include('admin.message')
    @if($rows->total() > 0)
    <div class="py-30 px-30 rounded-4 bg-white shadow-3">
        <div class="tabs -underline-2 js-tabs">
            <div class="tabs__contentjs-tabs-content">
                <div class="tabs__pane -tab-item-1 is-tab-el-active">
                    <div class="row y-gap-20">
                        @foreach($rows as $row)
                            <div class="col-md-12">
                                @include('User::frontend.wishList.loop-list')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="bravo-pagination">
            <span class="count-string">{{ __("Showing :from - :to of :total",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
            {{$rows->appends(request()->query())->links()}}
        </div>
    </div>
    @else
        {{__("No Items")}}
    @endif
@endsection
