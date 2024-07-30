<div class="effect">
    <div class="owl-carousel">
        @foreach($list_slider as $item)
            @php $img = get_file_url($item['bg_image'],'full') @endphp
            <div class="item" style="background-image: linear-gradient(0deg,rgba(0, 0, 0, 0.2),rgba(0, 0, 0, 0.2)),url('{{$img}}') !important">
                <h2 class="sub-heading text-center">{{ $item['desc'] ?? "" }}</h2>
                <h1 class="text-heading text-center">{{ $item['title'] ?? "" }}</h1>
            </div>
        @endforeach
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @include("Template::frontend.blocks.form-search-all-service.form-search")
        </div>
    </div>
</div>
