<?php
//if(!setting_item('tour_enable_inbox')) return;
$vendor = $row->author;
?>
@if(!empty($vendor->id))
<div class="owner-info widget-boxrounded-4 border-light shadow-4 bg-white w-100 mb-20 rounded-1">
    <div class="media d-flex">
        <div class="media-left mr-5 pt-1">
            <a href="{{route('user.profile',['id'=>$vendor->user_name ?? $vendor->id])}}" class="avatar-cover" style="background-image: url('{{$vendor->getAvatarUrl()}}');background-size: cover" >
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading"><a class="author-link" href="{{route('user.profile',['id'=>$vendor->user_name ?? $vendor->id])}}">{{$vendor->getDisplayName()}}</a>
                @if($vendor->is_verified)
                    <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-vefified-1.svg')}}" title="{{__("Verified")}}" alt="{{__("Verified")}}">
                @else
                    <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-not-vefified-1.svg')}}" title="{{__("Not verified")}}" alt="{{__("Verified")}}">
                @endif
            </h4>
            <p>{{ __("Member Since :time",["time"=> date("M Y",strtotime($vendor->created_at))]) }}</p>
            @if((!Auth::check() or Auth::id() != $row->author_id ) and setting_item('inbox_enable'))
                <a class="btn bc_start_chat" href="{{route('user.chat',['user_id'=>$row->author_id])}}" ><i class="icon ion-ios-chatboxes"></i> {{__('Message host')}}</a>
            @endif
        </div>
    </div>
</div>
@endif
