<div class="g-faq border-0 p-0 m-0 bravo-faq-lists" style="border:none;">
    <h3 class="text-22 fw-500"> {{__("FAQs")}} </h3>
    <div class="accordion -simple row y-gap-20 pt-30 js-accordion faqs-item">
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
