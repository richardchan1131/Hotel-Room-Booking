<section data-anim-wrap class="flight-search masthead -type-10">
    <div class="container-1500">
        <div class="row">
            <div class="col-lg-auto">
                <div class="masthead__content">
                    <h1 data-anim-child="slide-up delay-1" class="text-60 lg:text-40 sm:text-30">{{$title}}</h1>
                    <p data-anim-child="slide-up delay-2" class="mt-5">{{$sub_title}}</p>

                    <div data-anim-child="slide-up delay-3">

                        <div class="mainSearch -col-4 -w-1070 bg-white shadow-1 rounded-4 pr-20 py-20 lg:px-20 lg:pt-5 lg:pb-20 mt-15">
                                <div class="g-form-control">
                                    @include('Flight::frontend.layouts.search.form-search',['style'=>'flightCarousel'])
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@if(!empty($list_slider))
        <div data-anim-child="slide-left delay-6" class="masthead__image">
            <div class="row y-gap-30">
                @foreach($list_slider as $item)
                    @php $img = get_file_url($item['bg_image'],'full') @endphp
                    <div class="col-auto">
                        <img src="{{$img}}" alt="image" class="rounded-16">
                    </div>
                @endforeach
            </div>
        </div>
@endif
    </div>
</section>
