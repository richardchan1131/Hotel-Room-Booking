@php $key_time = time(); @endphp
<section class="layout-pt-md layout-pb-lg">
    <div data-anim-wrap class="container">
        <div class="tabs -pills-2 js-tabs">
            <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{$sub_title ?? ''}}</p>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="tabs__controls row x-gap-10 justify-center js-tabs-controls">
                        @if(!empty($service_types))
                            @php $number = 0; @endphp
                            @foreach ($service_types as $service_type)
                                @php
                                    $allServices = get_bookable_services();
                                    if(empty($allServices[$service_type]) OR empty($rows[$service_type])) continue;
                                    $module = new $allServices[$service_type];
                                @endphp
                                <div class="col-auto">
                                    <button class="tabs__button text-14 fw-500 px-20 py-10 rounded-4 bg-light-2 js-tabs-button @if($number == 0) is-tab-el-active @endif" data-tab-target=".-tab-item-{{$service_type}}">
                                        {{ !empty($modelBlock["title_for_".$service_type]) ? $modelBlock["title_for_".$service_type] : $module->getModelName() }}
                                    </button>
                                </div>
                                @php $number++; @endphp
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="tabs__content pt-40 js-tabs-content">
                @if(!empty($service_types))
                    @php $number = 0; @endphp
                    @foreach ($service_types as $service_type)
                        @php
                            $allServices = get_bookable_services();
                            if(empty($allServices[$service_type]) OR empty($rows[$service_type])) continue;
                        @endphp
                        <div class="tabs__pane -tab-item-{{$service_type}} @if($number == 0) is-tab-el-active @endif">
                            <div class="row y-gap-30">
                                @foreach($rows[$service_type] as $row)
                                    <div data-anim-child="slide-left delay-{{$number+4}}" class="col-xl-3 col-lg-3 col-sm-6">
                                        @include(ucfirst($service_type).'::frontend.layouts.search.loop-grid')
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php $number++; @endphp
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
