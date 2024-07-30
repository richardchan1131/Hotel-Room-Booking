@if(!empty($breadcrumbs))
    <section data-anim="fade" class="d-flex items-center py-15">
        <div class="">
            <div class="row y-gap-10 items-center justify-between">
                <div class="col-auto">
                    <div class="row x-gap-10 y-gap-5 items-center text-14 text-light-1">
                        <div class="col-auto">
                            <div class=""><a href="{{ url("/") }}"> <i class="fa fa-home"></i> {{ __('Home')}}</a></div>
                        </div>
                        <div class="col-auto"><div class="">></div></div>
                        @foreach($breadcrumbs as $breadcrumb)
                            <div class="col-auto {{$breadcrumb['class'] ?? ''}}">
                                @if(!empty($breadcrumb['url']))
                                    <div><a href="{{url($breadcrumb['url'])}}">{{$breadcrumb['name']}}</a></div>
                                @else
                                    <div class="text-dark-1">{{$breadcrumb['name']}}</div>
                                @endif
                            </div>
                            @if(!empty($breadcrumb['url']))
                                <div class="col-auto"><div class="">></div></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<div class="location_banner">
    @php $banner = $row->getBannerImageUrlAttribute('full') @endphp
    <div class="relative d-flex">
        @if(!empty($banner))
            <img src="{{ $banner }}" alt="{{$translation->name}}" class="col-12 rounded-4">
        @else
            <div class="w-100 min-height-300 bg-dark-1"></div>
        @endif
        <div class="effect"></div>
        <div class="absolute z-2 px-50 py-60 text-banner">
            <h1 class="text-50 fw-600 text-white">{{$translation->name}}</h1>
            <div class="text-white">{{ __("Explore deals, travel guides and things to do in :text",['text'=>$translation->name]) }}</div>
        </div>
    </div>
</div>
<div class="row x-gap-20 y-gap-20 items-center pt-20">
    @php $types = get_bookable_services() @endphp
    @if(!empty($types))
        @foreach($types as $type=>$moduleClass)
            @php
                if(!$moduleClass::isEnable()) continue;
            @endphp
            <div class="col">
                <a href="{{ $moduleClass::getLinkForPageSearch(false,['location_id'=>$row->id]) }}" class="d-flex flex-column justify-center px-20 py-15 rounded-4 border-light text-16 lh-14 fw-500 col-12">
                    <i class="{{ call_user_func([$moduleClass,'getServiceIconFeatured']) }} text-25 mb-10"></i>
                    {{ call_user_func([$moduleClass,'getModelName']) }}
                </a>
            </div>
        @endforeach
    @endif
</div>
