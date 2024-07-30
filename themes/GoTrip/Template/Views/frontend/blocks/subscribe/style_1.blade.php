<section data-anim="slide-up delay-1" class="layout-pt-md layout-pb-md">
    <div class="container">
        <div class="row ml-0 mr-0 items-center justify-between">
            <div class="col-xl-5 px-0">
                <img src="{{ $bg_image_url ?? "" }}" alt="image" data-src="{{ $bg_image_url ?? "" }}" class="js-lazy col-12 h-400">
            </div>

            <div class="col px-0">
                <div class="d-flex justify-center flex-column h-400 px-80 py-40 md:px-30 bg-light-2">
                    <div class="icon-newsletter text-60 sm:text-40 text-dark-1"></div>
                    <h2 class="text-30 sm:text-24 lh-15 mt-20">{{ $title ?? '' }}</h2>
                    <p class="text-dark-1 mt-5">{{ $sub_title ?? '' }}</p>

                    <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form">
                        @csrf
                        <div class="single-field -w-410 d-flex x-gap-10 flex-wrap y-gap-20 pt-30">
                            <div class="col-auto">
                                <input class="col-12 bg-white h-60" name="email" type="text" placeholder="{{__('Your Email')}}">
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="button -md h-60 -blue-1 bg-yellow-1 text-dark-1">{{__('Subscribe')}}</button>
                            </div>
                            <div class="form-mess"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
