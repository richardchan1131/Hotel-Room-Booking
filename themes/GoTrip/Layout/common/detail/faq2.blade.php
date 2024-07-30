<div class="row y-gap-20 bravo-faq-lists" style="border:none;">
    <div class="col-lg-4">
        <h2 class="text-22 fw-500">{{__('FAQs about')}}<br> {{$translation->title}}</h2>
    </div>
    <div class="col-lg-8">
        <div class="accordion -simple row y-gap-20 js-accordion faqs-item">
            @foreach($faqs as $k => $item)
                <div class="col-12">
                    <div class="accordion__item px-20 py-20 border-light rounded-4 item">
                        <div class="accordion__button d-flex items-center">
                            <div class="accordion__icon size-40 flex-center bg-light-2 rounded-full mr-20">
                                <i class="icon-plus"></i>
                                <i class="icon-minus"></i>
                            </div>

                            <div class="button text-dark-1">{{$item['title']}}</div>
                        </div>

                        <div class="accordion__content" style="">
                            <div class="pt-20 pl-60">
                                <p class="text-15">{{$item['content']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
