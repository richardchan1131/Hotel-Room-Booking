@if(!empty($list_item))
<section class="section-bg pt-40 pb-40">
    <div class="section-bg__item -left-100 -right-100 border-bottom-light"></div>
    <div class="container">
        <div class="row y-gap-30 justify-center text-center">
            @foreach($list_item as $item)
                <div class="col-xl-3 col-6">
                    <div class="text-40 lh-13 text-blue-1 fw-600">{{ $item['number'] }}</div>
                    <div class="text-14 lh-14 text-light-1 mt-5">{{ $item['title'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
