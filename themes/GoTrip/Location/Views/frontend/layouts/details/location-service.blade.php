@php $types = get_bookable_services() @endphp
@if(!empty($types))
    @php $i = 0 ;$not_in =['flight']@endphp
    @foreach($types as $type=>$moduleClass)
        @php
            if(!$moduleClass::isEnable() or in_array($type,$not_in)==true) continue;
            $moduleInst = new $moduleClass();
            $services = $moduleInst->select($moduleInst::getTableName().'.*')
            ->join('bravo_locations', function ($join) use ($row,$moduleInst) {
                $join->on('bravo_locations.id', '=', $moduleInst::getTableName().'.location_id')
                    ->where('bravo_locations._lft', '>=', $row->_lft)
                    ->where('bravo_locations._rgt', '<=', $row->_rgt);
            })
            ->where($moduleInst::getTableName().'.status','publish')->with('location')->take(8)->get();
        @endphp
        @if($services->count()>0)

            <section class="layout-pt-md layout-pb-md bravo-location-service-list">
                <div class="row y-gap-20 justify-between items-end">
                    <div class="col-auto">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title">{{ __('Most Popular :name',['name'=> call_user_func([$moduleClass,'getModelName']) ]) }}</h2>
                            <p class=" sectionTitle__text mt-5 sm:mt-0">{{ __("Interdum et malesuada fames ac ante ipsum") }}</p>
                        </div>
                    </div>

                    <div class="col-auto">
                        <a href="{{$row->getLinkForPageSearch($type)}}" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                            {{__('View More')}} <div class="icon-arrow-top-right ml-15"></div>
                        </a>
                    </div>
                </div>
                <div class="row y-gap-30 pt-40 sm:pt-20">
                    @foreach($services as $service)
                        <div class="col-xl-3 col-lg-3 col-sm-6 loop-type-{{ $type }}">
                            @php
                                $view = ucfirst($type).'::frontend.layouts.search.loop-grid';
                            @endphp
                            @if(view()->exists($view))
                                @include($view,['row' => $service])
                            @endif

                        </div>
                    @endforeach
                </div>
            </section>
            @php $i++ @endphp
        @endif
    @endforeach
@endif
