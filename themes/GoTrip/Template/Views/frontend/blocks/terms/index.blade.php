<section class="layout-pt-lg layout-pb-lg">
    <div class="container">
        <div class="tabs js-tabs">
            <div class="row y-gap-30">
                <div class="col-lg-3">
                    <div class="px-30 py-30 rounded-4 border-light">
                        <div class="tabs__controls row y-gap-10 js-tabs-controls">
                            @if(!empty($list_item))
                                @foreach($list_item as $key=>$item)
                                    <div class="col-12">
                                        <button class="tabs__button js-tabs-button is-tab-el-active" data-tab-target=".-tab-item-{{ $key }}">{{ $item['title'] }}</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="tabs__content js-tabs-content">
                        @if(!empty($list_item))
                            @foreach($list_item as $key=>$item)
                                <div class="tabs__pane -tab-item-{{ $key }} @if($key == 0) is-tab-el-active @endif">
                                    <h1 class="text-30 fw-600 mb-15">{{ $item['title'] }}</h1>
                                    <div>
                                        {!! $item['desc'] !!}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
