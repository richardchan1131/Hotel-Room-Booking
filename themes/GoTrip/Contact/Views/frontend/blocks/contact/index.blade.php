<div class="bravo-contact-block">
    <div class="ratio ratio-16:9">
        <div class="map-ratio">
            <div class="iframe_map">
                {!! ( setting_item("page_contact_iframe_google_map")) !!}
            </div>
        </div>
    </div>
    <section>
        <div class="relative container">
            <div class="row justify-end">
                <div class="col-xl-5 col-lg-7">
                    <form method="post" action="{{ route("contact.store") }}" class="bravo-contact-block-form">
                        {{csrf_field()}}
                        <div style="display: none;">
                            <input type="hidden" name="g-recaptcha-response" value="">
                        </div>
                        <div
                            class="map-form px-40 pt-40 pb-30 lg:px-30 lg:py-30 md:px-24 md:py-24 bg-white rounded-4 shadow-4">
                            <div class="text-22 fw-500">
                                {{ __("Send a message") }}
                            </div>
                            <div class="row y-gap-20 pt-20">
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input type="text" required name="name">
                                        <label class="lh-1 text-16 text-light-1">{{ __("Full Name") }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input type="text" required name="email">
                                        <label class="lh-1 text-16 text-light-1">{{ __("Email") }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <textarea required rows="4" name="message"></textarea>
                                        <label class="lh-1 text-16 text-light-1">{{ __('Your Messages') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{recaptcha_field('contact')}}
                                </div>
                                <div class="col d-flex justify-content-lg-start">
                                    <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white">
                                        {{ __("Send a Messsage") }}
                                        <i class="fa fa-spinner fa-pulse fa-fw d-none"></i>
                                        <div class="icon-arrow-top-right ml-15"></div>
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-mess"></div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row x-gap-80 y-gap-20 justify-between">
                <div class="col-12">
                    <div class="text-30 sm:text-24 fw-600">{{ setting_item_with_lang("page_contact_title") }}</div>
                </div>
                @if(!empty($contact_lists = setting_item_with_lang("page_contact_lists")))
                    @php  $contact_lists = json_decode($contact_lists,true) @endphp

                    @foreach( $contact_lists as $item)
                        <div class="col-md-6 col-lg-3">
                            <div class="text-14 text-light-1">{{ $item['title'] }}</div>
                            <div class="text-18 fw-500 d-flex items-center mt-10">{!! clean($item['content'] ?? "") !!}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    @if(!empty( $page_contact_why_choose_us = setting_item_with_lang('page_contact_why_choose_us')))
        @php $page_contact_why_choose_us = json_decode($page_contact_why_choose_us,true) @endphp
        <section class="layout-pt-lg layout-pb-lg bg-blue-2">
            <div class="container">
                <div class="row justify-center text-center">
                    <div class="col-auto">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title">{{ setting_item_with_lang('page_contact_why_choose_us_title') }}</h2>
                            <p class=" sectionTitle__text mt-5 sm:mt-0">{{ setting_item_with_lang('page_contact_why_choose_us_desc') }}r</p>
                        </div>
                    </div>
                </div>
                <div class="row y-gap-40 justify-between pt-50">
                    @foreach($page_contact_why_choose_us as $key=>$item)
                        <div class="col-lg-3 col-sm-6">
                            <div class="featureIcon -type-1 ">
                                <div class="d-flex justify-center">
                                    <img src="{{ get_file_url($item['image_id'],'full') }}" alt="{{$item['title']}}">
                                </div>
                                <div class="text-center mt-30">
                                    <h4 class="text-18 fw-500">{{$item['title']}}</h4>
                                    <p class="text-15 mt-10">{{$item['desc']}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
