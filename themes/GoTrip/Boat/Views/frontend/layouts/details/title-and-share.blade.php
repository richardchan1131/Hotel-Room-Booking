<section class="pt-40">
    <div class="container">
        <div class="row justify-between items-end">
            <div class="col-auto">
                <h1 class="text-26 fw-600">{{ $translation->title }}</h1>

                <div class="d-flex x-gap-5 items-center pt-5">
                    <i class="icon-location-2 text-16 text-light-1"></i>
                    <div class="text-15 text-light-1">{{ $translation->address }}</div>
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
</section>
