<section data-anim-wrap class="masthead -type-3 relative z-5 form_search_style_2">
    <div data-anim-child="fade delay-1" class="masthead__bg bg-dark-3">
        <img src="{{ $bg_image_url }}"alt="image" data-src="{{ $bg_image_url }}" class="js-lazy">
    </div>
    <div class="container">
        <div class="row justify-center">
            <div class="col-xl-10">
                <div class="text-center">
                    <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">{{ $title }}</h1>
                    <p data-anim-child="slide-up delay-5" class="text-white mt-6 md:mt-10">{{ $sub_title }}</p>
                </div>
                <div data-anim-child="slide-up delay-6" class="masthead__tabs">
                    <div class="tabs -bookmark js-tabs">
                        <div class="tabs__controls d-flex items-center js-tabs-controls">
                            @if($service_types)
                                @php $allServices = get_bookable_services(); $number = 0; @endphp
                                @foreach($service_types as $service_type)
                                    @php
                                        if(empty($allServices[$service_type])) continue;
                                        $service = $allServices[$service_type];
                                    @endphp
                                    <div class="">
                                        <button class="tabs__button px-30 py-20 rounded-4 fw-600 text-white js-tabs-button @if($number==0) is-tab-el-active @endif" data-tab-target=".-tab-item-{{$service_type}}">
                                            <i class="{{$icons[$service_type]}} text-20 mr-10"></i>
                                            {{$service::getModelName()}}
                                        </button>
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </div>
                        <div class="tabs__content js-tabs-content">
                            @if($service_types)
                                @php $number = 0; @endphp
                                @foreach($service_types as $k => $service_type)
                                    @php
                                        if(empty($allServices[$service_type])) continue;
                                    @endphp
                                    <div class="tabs__pane -tab-item-{{$service_type}} @if($number==0) is-tab-el-active @endif">
                                        @include(ucfirst($service_type).'::frontend.layouts.search.form-search', ['style' => 'normal2'])
                                    </div>
                                    @php $number++; @endphp
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
