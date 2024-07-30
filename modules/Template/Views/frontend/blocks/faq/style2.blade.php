<div class="bravo-faq-lists">
    <div class="container">
        <h2 class="title text-center mb40">{{$title ?? ''}}</h2>
        @if(!empty($list_item))
            <div class="g-faq">
                @foreach($list_item as $item)
                    <div class="item">
                        <div class="header">
                            <i class="field-icon icofont-support-faq"></i>
                            <h5>{{$item['title']}}</h5>
                            <span class="arrow"><i class="fa fa-angle-down"></i></span>
                        </div>
                        <div class="body">
                            {!! clean($item['sub_title'],'html5-definitions') !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@push('js')
    <script>
        $(".g-faq .item .header").click(function () {
            $(this).parent().toggleClass("active");
        });
    </script>
@endpush
