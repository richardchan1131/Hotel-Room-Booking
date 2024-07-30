<section data-anim-wrap class="form-search-all-service masthead -type-1 z-5">
    <div data-anim-child="fade" class="masthead__bg">
        <img src="{{ $bg_image_url }}" alt="image" data-src="{{ $bg_image_url }}" class="js-lazy">
    </div>

    <div class="container">
        <div class="row justify-center">
            <div class="col-auto">
                <div class="text-center">
                    <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">{{ $title }}</h1>
                    <p data-anim-child="slide-up delay-5" class="text-white mt-6 md:mt-10">{{ $sub_title }}</p>
                </div>

                @if(empty($hide_form_search))
                    <div data-anim-child="slide-up delay-6" class="tabs -underline mt-60 js-tabs">
                        <div class="tabs__controls d-flex x-gap-30 y-gap-20 justify-center sm:justify-start js-tabs-controls">
                            @if($service_types)
                                @php $allServices = get_bookable_services(); $number = 0; @endphp
                                @foreach($service_types as $service_type)
                                    @php
                                        if(empty($allServices[$service_type])) continue;
                                        $service = $allServices[$service_type];
                                    @endphp
                                    <div class="">
                                        <button class="tabs__button text-15 fw-500 text-white pb-4 js-tabs-button @if($number==0) is-tab-el-active @endif" data-tab-target=".-tab-item-{{$service_type}}">
                                            {{$service::getModelName()}}
                                        </button>
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif

                        </div>

                        <div class="tabs__content mt-30 md:mt-20 js-tabs-content">
                            @if($service_types)
                                @php $number = 0; @endphp
                                @foreach($service_types as $k => $service_type)
                                    @php
                                        if(empty($allServices[$service_type])) continue;
                                    @endphp
                                    <div class="tabs__pane -tab-item-{{$service_type}} @if($number==0) is-tab-el-active @endif">
                                        @include(ucfirst($service_type).'::frontend.layouts.search.form-search', ['style' => 'normal'])
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
