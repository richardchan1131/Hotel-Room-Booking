<section class="bravo-faq-lists layout-pt-lg layout-pb-lg">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>
        @if(!empty($list_item))
            <div class="row y-gap-30 justify-center pt-40 sm:pt-20">
                <div class="col-xl-8 col-lg-10">
                    <div class="accordion -simple row y-gap-20 js-accordion">
                        @foreach($list_item as $item)
                            <div class="col-12">
                                <div class="accordion__item px-20 py-20 border-light rounded-4">
                                    <div class="accordion__button d-flex items-center">
                                        <div class="accordion__icon size-40 flex-center bg-light-2 rounded-full mr-20">
                                            <i class="icon-plus"></i>
                                            <i class="icon-minus"></i>
                                        </div>
                                        <div class="button text-dark-1">{{$item['title']}}</div>
                                    </div>
                                    <div class="accordion__content">
                                        <div class="pt-20 pl-60">
                                            <p class="text-15"> {!! clean($item['sub_title'],'html5-definitions') !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
