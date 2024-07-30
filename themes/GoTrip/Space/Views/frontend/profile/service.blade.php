<?php
if(!$user->hasPermission('space_create')) return;
?>
@if(!empty($services) and $services->total())
    <div class="bravo-profile-list-services">

        <div class="list-item">
            <div class="row">
                @foreach($services as $row)
                    <div class="col-xl-4 col-lg-4 col-sm-6 mb-30">
                        @include('Space::frontend.layouts.search.loop-grid')
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container">
            @if(!empty($view_all))
                <div class="review-pag-wrapper">
                    <div class="bravo-pagination">
                        {{$services->appends(request()->query())->links()}}
                    </div>
                    <div class="review-pag-text text-center">
                        {{ __("Showing :from - :to of :total total",["from"=>$services->firstItem(),"to"=>$services->lastItem(),"total"=>$services->total()]) }}
                    </div>
                </div>
            @else
                <div class="text-center mt30"><a class="button h-50 px-24 -dark-1 bg-blue-1 text-white d-inline-flex" href="{{route('user.profile.services',['id'=>$user->user_name ?? $user->id,'type'=>'space'])}}">{{__('View all (:total)',['total'=>$services->total()])}}</a></div>
            @endif
        </div>
    </div>
@endif
