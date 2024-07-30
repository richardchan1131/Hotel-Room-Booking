@if(!empty($list_item))
<section class="layout-pt-md layout-pb-lg">
    <div data-anim="slide-up delay-1" class="container">
        <div class="row justify-center text-center">
            @foreach($list_item as $item)
                <div class="col-xl-3 col-sm-6">
                    <div class="text-40 lh-13 text-blue-1 fw-600">{{ $item['number'] }}</div>
                    <div class="text-14 lh-14 text-light-1 mt-5">{{ $item['title'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
