@if($list_item)
    <div class="bravo-client-feedback">
        <div class="row">
            <div class="col-md-6 d-flex align-content-center">
                @if(!empty($image_url))
                    <img class="i" src="{{ $image_url }}" alt="xx">
                @endif
            </div>
            <div class="col-md-6">
                <div class="list-item owl-carousel">
                    @foreach($list_item as $k=>$item)
                        <div class="item">
                            <i class="icofont-quote-right"></i>
                            <div class="title">
                                {{ $item['title'] }}
                            </div>
                            <div class="sub_title">
                                {{ $item['sub_title'] }}
                            </div>
                            <div class="desc">
                                {{ $item['desc'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
