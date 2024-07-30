<section class="pt-40">
    <div class="container">
        <div class="row y-gap-30">
            <div class="col-lg-8">
                <div class="row y-gap-20 justify-between items-end">
                    <div class="col-auto">
                        <h1 class="text-30 sm:text-24 fw-600">{{$translation->title}}</h1>
                        <div class="row x-gap-10 items-center pt-10">
                            <div class="col-auto">
                                <div class="d-flex x-gap-5 items-center">
                                    <i class="icon-location text-16 text-light-1"></i>
                                    <div class="text-15 text-light-1">{{$translation->address}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="row x-gap-10 y-gap-10">
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="button px-15 py-10 -blue-1 dropdown-toggle" type="button" id="dropdownMenuShare" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-share mr-10"></i>
                                        {{__('Share')}}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuShare">
                                        <a class="dropdown-item facebook" href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                                            <i class="fa fa-facebook"></i> {{ __('Facebook') }}
                                        </a>
                                        <a class="dropdown-item twitter" href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                                            <i class="fa fa-twitter"></i> {{ __('Twitter') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                                    <button class="button px-15 py-10 -blue-1 bg-light-2">
                                        <i class="icon-heart mr-10"></i>
                                        {{__('Save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($row->getGallery())
                    <div class="mt-20">
                        @include('Layout::common.detail.gallery5',['galleries' => $row->getGallery()])
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                @include('Car::frontend.layouts.details.form-book')
                <div class="justify-end mt-30 d-none">
                    @include('Layout::common.detail.vendor')
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pt-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div>
                    <h3 class="text-22 fw-500">
                        {{ __("Property highlights") }}
                    </h3>
                    <div class="row y-gap-30 justify-between pt-20">
                        <div class="col-md-auto col-6">
                            <div class="d-flex">
                                <i class="icon-user-2 text-22 text-dark-1 mr-10"></i>
                                <div class="text-15 lh-15">
                                    {{__("Passenger")}} <br> {{$row->passenger}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto col-6">
                            <div class="d-flex">
                                <i class="icon-luggage text-22 text-dark-1 mr-10"></i>
                                <div class="text-15 lh-15">
                                    {{__("Baggage")}}<br>{{$row->baggage}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto col-6">
                            <div class="d-flex">
                                <i class="icon-transmission text-22 text-dark-1 mr-10"></i>
                                <div class="text-15 lh-15">
                                    {{__("Gear Shift")}}<br>{{$row->gear}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto col-6">
                            <div class="d-flex">
                                <i class="icon-speedometer text-22 text-dark-1 mr-10"></i>
                                <div class="text-15 lh-15">
                                    {{__("Door")}}<br>{{$row->door}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-top-light mt-40 mb-40"></div>
                <div class="gotrip-overview">
                    <h3 class="text-22 fw-500">{{ __("Overview") }}</h3>
                    <div class="text-dark-1 text-15 mt-20">
                        {!! clean($translation->content) !!}
                    </div>
                </div>
                <div class="border-top-light mt-40 mb-40"></div>
                @include('Car::frontend.layouts.details.attributes')
                <div class="border-top-light mt-40"></div>
            </div>
        </div>
    </div>
</section>

@if($row->map_lat && $row->map_lng)
    <section class="mt-40">
        @include('Layout::map.detail.map')
    </section>
@endif
<div class="mt-40"></div>
<section>
    <div class="container">
        @if($translation->faqs)
            @include('Layout::common.detail.faq2',['faqs'=>$translation->faqs])
        @endif
    </div>
</section>
<div class="container mt-40 mb-40">
    <div class="border-top-light"></div>
</div>
<section>
    <div class="container">
        @include('Layout::common.detail.review')
    </div>
</section>
<div class="mt-40"></div>

<div class="container">
    @include('Car::frontend.layouts.details.related')
</div>

<div class="layout-pt-lg"></div>
