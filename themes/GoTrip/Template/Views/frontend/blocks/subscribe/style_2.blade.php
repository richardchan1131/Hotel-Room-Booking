<section data-anim-wrap class="section-bg layout-pt-lg layout-pb-lg mailchimp">
    <div data-anim-child="fade delay-1" class="section-bg__item -mx-20 bg-blue-1"></div>

    <div class="container">
        <div data-anim-child="slide-up delay-2" class="row items-center justify-center text-center">
            <div class="col-auto">
                <i class="icon-newsletter text-60 sm:text-40 text-white"></i>

                <h2 class="text-30 sm:text-24 lh-15 text-white mt-20">{{ $title ?? '' }}</h2>
                <p class="text-white mt-5">{{ $sub_title ?? '' }}</p>

                <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form">
                    @csrf
                    <div class="single-field -w-410 d-flex x-gap-10 flex-wrap y-gap-20 pt-30">
                        <div class="col-auto">
                            <input class="col-12 bg-white h-60" name="email" type="text" placeholder="{{__('Your Email')}}">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="button -md -white h-60 bg-dark-1 text-white">{{__('Subscribe')}}</button>
                        </div>
                        <div class="form-mess"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
