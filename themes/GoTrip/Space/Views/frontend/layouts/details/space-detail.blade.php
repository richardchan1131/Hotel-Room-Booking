<section class="pt-40 g-header">
    <div class="container">
        <div class="row y-gap-30">
            <div class="col-12">
                <div class="row justify-between items-end">
                    <div class="col-auto">
                        <h1 class="text-26 fw-600">{{$translation->title}}</h1>

                        <div class="row x-gap-20 y-gap-20 items-center pt-10">
                            <div class="col-auto">
                                <div class="row x-gap-10 items-center">
                                    <div class="col-auto">
                                        <div class="d-flex x-gap-5 items-center">
                                            <i class="icon-location-2 text-16 text-light-1"></i>
                                            <div class="text-15 text-light-1">{{$translation->address}}</div>
                                        </div>
                                    </div>
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
            </div>
        </div>
    </div>
</section>

@if($row->getGallery())
    @include('Layout::common.detail.gallery2',['galleries' => $row->getGallery()])
@endif

<section class="pt-40">
    <div class="container js-pin-container">
        <div class="row y-gap-30">
            <div class="col-lg-8">
                <div>
                    <h3 class="text-22 fw-500">{{ __('Property highlights') }}</h3>

                    <div class="row y-gap-30 justify-between pt-20">
                        @if(!empty($row->bed))
                            <div class="col-md-auto col-6">
                                <div class="d-flex">
                                    <i class="icon-bed text-22 text-blue-1 mr-10"></i>
                                    <div class="text-15 lh-15">
                                        {{ __('Bedrooms') }}<br> {{$row->bed}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($row->bathroom)
                            <div class="col-md-auto col-6">
                                <div class="d-flex">
                                    <i class="icon-bathtub text-22 text-blue-1 mr-10"></i>
                                    <div class="text-15 lh-15">
                                        {{ __('Bathroom') }}<br> {{$row->bathroom}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($row->square)
                            <div class="col-md-auto col-6">
                                <div class="d-flex">
                                    <i class="fa fa-crop text-22 text-blue-1 mr-10"></i>
                                    <div class="text-15 lh-15">
                                        {{__("Square")}}<br> {!! size_unit_format($row->square) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!empty($row->location->name))
                            @php $location =  $row->location->translate() @endphp
                            <div class="col-md-auto col-6">
                                <div class="d-flex">
                                    <i class="icon-location text-22 text-blue-1 mr-10"></i>
                                    <div class="text-15 lh-15">
                                        {{__("Location")}}<br> {{$location->name ?? ''}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="border-top-light mt-40 mb-40"></div>

                @if($translation->content)
                    <div>
                        <h3 class="text-22 fw-500">{{__('Description')}}</h3>
                        <div class="description">
                            {!! clean($translation->content) !!}
                        </div>
                    </div>
                @endif
                @include('Space::frontend.layouts.details.space-attributes')
                <div class="border-top-light mt-40 mb-40"></div>
                @if($translation->faqs)
                    @include('Layout::common.detail.faq',['faqs'=>$translation->faqs])
                @endif
            </div>

            <div class="col-lg-4">
                @include('Space::frontend.layouts.details.space-form-book')
            </div>
        </div>
        <div class="border-top-light mt-40 mb-40"></div>
    </div>
</section>
