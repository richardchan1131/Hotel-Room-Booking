<div class="relative">
    <div class="border-test"></div>
    <div class="accordion -map row y-gap-20 js-accordion">
        @if($translation->itinerary)
            @foreach($translation->itinerary as $key => $item)
                <div class="col-12">
                    <div class="accordion__item @if($key == 0) js-accordion-item-active @endif">
                        <div class="d-flex">
                            <div class="accordion__icon size-40 flex-center bg-blue-2 text-blue-1 rounded-full">
                                <div class="text-14 fw-500">{{$key+1}}</div>
                            </div>
                            <div class="ml-20">
                                <div class="text-16 lh-15 fw-500">{{$item['title']}}</div>
                                <div class="text-14 lh-15 text-light-1 mt-5">{{$item['desc']}}</div>

                                <div class="accordion__content">
                                    <div class="pt-15 pb-15">
                                        <img src="{{ !empty($item['image_id']) ? get_file_url($item['image_id'],"full") : "" }}" alt="{{$item['desc']}}" class="rounded-4 mt-15">
                                        <div class="text-14 lh-17 mt-15">{!! clean($item['content']) !!}</div>
                                    </div>
                                </div>
                                <div class="accordion__button">
                                    <button data-open-change-title="{{__('See less')}}" class="d-block lh-15 text-14 text-blue-1 underline fw-500 mt-5">
                                        {{__('See details & photo')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
