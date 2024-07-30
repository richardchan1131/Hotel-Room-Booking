<section class="layout-pt-md layout-pb-md bg-dark-2">
    <div class="container">
        <div class="row y-gap-30 justify-between items-center">
            <div class="col-auto">
                <div class="row y-gap-20  flex-wrap items-center">
                    <div class="col-auto">
                        <div class="icon-newsletter text-60 sm:text-40 text-white"></div>
                    </div>

                    <div class="col-auto">
                        <h4 class="text-26 text-white fw-600">{{ $title ?? '' }}</h4>
                        <div class="text-white">{{ $sub_title ?? '' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <form action="{{route('newsletter.subscribe')}}" class="subcribe-form bravo-subscribe-form bravo-form">
                    @csrf
                    <div class="single-field -w-410 d-flex x-gap-10 y-gap-20">
                        <div>
                            <input class="bg-white h-60" type="text" name="email" placeholder="{{ __("Your Email") }}">
                        </div>
                        <div>
                            <button type="submit" class="button -md h-60 bg-blue-1 text-white">{{ __("Subscribe") }}</button>
                        </div>
                    </div>
                    <div class="form-mess text-white pt-2"></div>
                </form>
            </div>
        </div>
    </div>
</section>
