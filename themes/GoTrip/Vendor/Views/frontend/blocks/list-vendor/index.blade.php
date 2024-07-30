<div class="bravo-list-vendor">
    <div class="container">
        @if($title)
            <div class="title">
                {{$title}}
                @if(!empty($desc))
                    <div class="sub-title">
                        {{$desc}}
                    </div>
                @endif
            </div>
        @endif
        <div class="list-item">
            <div class="row">
                @foreach($rows as $row)
                    <div class="col-lg-{{$col ?? 3}} col-md-6 mb-4">
                        <div class="item">
                            <div class="image">
                                @if($avatar_url = $row->getAvatarUrl())
                                    <img src="{{ $avatar_url }}" alt="{{$row->getDisplayName()}}" class="w-100">
                                @endif
                            </div>
                            <h4 class="name">{{$row->getDisplayName()}}
                                @if($row->is_verified)
                                    <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-vefified-1.svg')}}" title="{{__("Verified")}}" alt="ico-vefified-1">
                                @else
                                    <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-not-vefified-1.svg')}}" title="{{__("Not verified")}}" alt="ico-vefified-1">
                                @endif
                            </h4>
                            <span class="designation">{{ __("Member Since :time",["time"=> date("M Y",strtotime($row->created_at))]) }}</span>
                            @if(setting_item('vendor_show_email') or setting_item('vendor_show_phone'))
                                @if(setting_item('vendor_show_email'))
                                    <div class="text">
                                        {{$row->email}}
                                    </div>
                                @endif
                                @if(setting_item('vendor_show_phone'))
                                    <div class="text">
                                        {{$row->phone}}
                                    </div>
                                @endif
                            @endif
                            @if($city = $row->city)
                                <div class="location">
                                    <i class="fa fa-location-arrow"></i> {{$city}}, {{$row->country}}
                                </div>
                            @endif
                            <a href="{{route('user.profile',['id'=>$row->user_name ?? $row->id])}}" class="btn btn-primary">
                                <span class="btn-title">{{ __("View Profile") }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>