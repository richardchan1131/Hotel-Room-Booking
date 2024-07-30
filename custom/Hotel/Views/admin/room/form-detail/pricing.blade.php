@if (is_default_lang())
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                <input type="number" required value="{{ $row->price }}" min="1" placeholder="{{ __('Price') }}"
                    name="price" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Number of room') }} <span class="text-danger">*</span></label>
                <input type="number" required value="{{ $row->number ?? 1 }}" min="1" max="100"
                    placeholder="{{ __('Number') }}" name="number" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ __('Max Children') }} </label>
                <input type="number" min="0" value="{{ $row->children ?? 0 }}" name="children"
                    class="form-control">
            </div>
        </div>
        <div class="col-md-8">
            <div id="kids_in_room">
                @foreach (Custom\Hotel\Models\OlteanuHotelChild::where('bravo_hotel_room_id', $row->id)->get() as $prices)
                    <div class="row" id="childrenPrices_{{ $prices->id }}">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    <a class="text-danger"
                                        href="javascript:deleteChildrenPrices('childrenPrices_{{ $prices->id }}')"><i
                                            class="fa fa-trash"></i></a>
                                    {{ __('Price for child') }} <span class="text-danger">*</span>
                                </label>
                                <input type="number" value="{{ $prices->price }}" placeholder="{{ __('Price for child') }}"
                                    name="kid_price[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Minimum age (years old)') }} <span class="text-danger">*</span></label>
                                <input type="number" value="{{ $prices->minimum_age }}"
                                    placeholder="{{ __('Minimum age (years old)') }}" name="kid_age_minimum[]"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Maximum age (years old)') }} <span class="text-danger">*</span></label>
                                <input type="number" value="{{ $prices->maximum_age }}"
                                    placeholder="{{ __('Maximum age (years old)') }}" name="kid_age_maximum[]"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                @endforeach
                <div id="default_kid_in_room">
                    <div class="row" id="customChildrenPrices_0">
                        <div class="col-md-4">
                            <div class="form-group">
                                <a class="text-danger"
                                    href="javascript:deleteChildrenPrices('customChildrenPrices_0')"><i
                                        class="fa fa-trash"></i></a>
                                <label>{{ __('Price for child') }} <span class="text-danger">*</span></label>
                                <input type="number" placeholder="{{ __('Price') }}" name="kid_price[]"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Minimum age (years old)') }} <span class="text-danger">*</span></label>
                                <input type="number" placeholder="{{ __('Minimum age (years old)') }}"
                                    name="kid_age_minimum[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('Maximum age (years old)') }} <span class="text-danger">*</span></label>
                                <input type="number" placeholder="{{ __('Maximum age (years old)') }}"
                                    name="kid_age_maximum[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="addKidPrices()"><i class="fa fa-add"></i>
                {{ __('Add price diferences for children') }}</button>
        </div>
    </div>
    @php
        $olteanu = Custom\Hotel\Models\OlteanuHotelRoom::where('bravo_hotel_room_id', $row->id)->first();
    @endphp
    <div class="pt-5 row">
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="suplimentary_bed">
                    {{ __('Suplimentary bed') }}
                </label>
                <input class="form-check-input ml-10 mt-2" type="checkbox" name="suplimentary_bed" id="suplimentary_bed"
                    value="1" @checked($olteanu?->additional_bed_active)>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label>{{ __('Pret pat suplimentar') }} <span class="text-danger">*</span></label>
                <input type="number" placeholder="{{ __('Pret pat suplimentar') }}" name="supplimentary_bed_price"
                    class="form-control" value="{{ $olteanu?->additional_bed_price }}">
            </div>
        </div>
    </div>
    <hr>
    <p class="text-center">
        {{ __('Select prices and settings for breakfast or all-inclusive *per person*') }}
    </p>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="breakfast_active">
                    {{ __('Breakfast') }}
                </label>
                <input class="form-check-input ml-10 mt-2" type="checkbox" id="breakfast_active" name="breakfast_active" value="1"
                @checked($olteanu?->breakfast_active)>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="number" placeholder="{{ __('Breakfast price') }}" name="breakfast_price"
                    class="form-control" value="{{ $olteanu?->breakfast_price }}">
                <i>{{ __('Enter 0 if you have breakfast included in room price.') }}</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="demipension_active">
                    {{ __('Demipension') }}
                </label>
                <input class="form-check-input ml-10 mt-2" type="checkbox" id="demipension_active" name="demipension_active" value="1"
                @checked($olteanu?->demipension_active)>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="number" placeholder="{{ __('Demipension price') }}" name="demipension_price"
                    class="form-control" value="{{ $olteanu?->demipension_price }}">
                <i>{{ __('Enter 0 if you have demipension included in room price.') }}</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="allinclusive_active">
                    {{ __('All-Inclusive') }}
                </label>
                <input class="form-check-input ml-10 mt-2" type="checkbox" id="allinclusive_active" name="allinclusive_active" value="1"
                @checked($olteanu?->allinclusive_active)>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="number" placeholder="{{ __('All-Inclusive price') }}" name="allinclusive_price"
                    class="form-control" value="{{ $olteanu?->allinclusive_price }}">
                <i>{{ __('Enter 0 if you have all-inclusive included in room price.') }}</i>
            </div>
        </div>
    </div>
    <hr>
    <p class="text-center">
        {{ __('Select prices and settings free-cancelation') }}
    </p>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <label class="form-check-label" for="freecancelation_active">
                    {{ __('Free cancelation') }}
                </label>
                <input class="form-check-input ml-10 mt-2" type="checkbox" id="freecancelation_active" name="freecancelation_active" value="1"
                @checked($olteanu?->freecancelation_active)>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="number" placeholder="{{ __('Free cancelation price') }}" name="freecancelation_price"
                    class="form-control" value="{{ $olteanu?->freecancelation_price }}">
                <i>{{ __('Enter 0 if you have free-cancelation included in room price.') }}</i>
            </div>
        </div>
    </div>
    <hr>
    <p class="text-center">
        {{ __('Select icons for beds and sofas') }}
    </p>
    <div class="row">
        <div class="col-md-3">
            <div class="d-flex items-center mt-10">
                <svg fill="#000000" width="50px" height="50px" class="ml-5" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path
                        d="M7 4C5.3550302 4 4 5.3550302 4 7L4 8.1816406C3.7749277 8.0988815 3.5394844 8.0375539 3.2871094 8.0136719L3.2851562 8.0136719L3.2832031 8.0136719C2.6956383 7.9593227 2.0975168 8.0789836 1.5742188 8.3613281C0.16654993 9.1184219 -0.29860155 10.832824 0.26367188 12.236328L1.9628906 16.486328C2.4842054 17.787329 3.6480233 18.703727 5 18.9375L5 21L7 21L7 19L17 19L17 21L19 21L19 18.935547C20.352474 18.701653 21.51686 17.786714 22.037109 16.484375L23.769531 12.214844L23.771484 12.212891C24.310637 10.863481 23.896019 9.2254763 22.582031 8.4355469C22.112992 8.1535386 21.573166 8 21.027344 8C20.669496 8 20.324639 8.0704493 20 8.1894531L20 7C20 5.3550302 18.64497 4 17 4L7 4 z M 7 6L17 6C17.56503 6 18 6.4349698 18 7L18 10.474609L16.972656 13L7.03125 13L6 10.421875L6 7C6 6.4349698 6.4349698 6 7 6 z M 21.027344 10C21.211522 10 21.377821 10.044449 21.550781 10.148438C21.946794 10.386508 22.114863 10.96816 21.914062 11.470703L20.179688 15.740234L20.179688 15.742188C19.875347 16.503993 19.143398 17 18.322266 17L5.6777344 17C4.8584657 17 4.125776 16.504733 3.8203125 15.744141L3.8203125 15.742188L2.1210938 11.494141L2.1210938 11.492188C1.9097193 10.964664 2.0972168 10.35068 2.5214844 10.123047L2.5234375 10.121094C2.7075381 10.021764 2.8861235 9.9846829 3.0976562 10.003906C3.4440291 10.036686 3.8135404 10.336585 3.984375 10.763672L5.6777344 15L18.318359 15L20.09375 10.634766L20.095703 10.630859C20.248971 10.247062 20.61453 10 21.027344 10 z" />
                </svg>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label>{{ __('No. of sofas') }} <span class="text-danger">*</span></label>
                <input type="number" placeholder="{{ __('No. of sofas') }}" name="sofa"
                    value="{{ $olteanu?->sofa }}" class="form-control">
                <i>{{ __('Leave blank if you dont have this type of furniture.') }}</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="d-flex items-center mt-10">
                <svg fill="#000000" width="48px" height="48px" viewBox="0 0 512 512" class="ml-5"
                    id="Layer_1" enable-background="new 0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path
                            d="m496 320c0-15.581 0-282.497 0-296 0-8.836-7.163-16-16-16s-16 7.164-16 16v16h-416v-16c0-8.836-7.164-16-16-16s-16 7.164-16 16v296c-8.836 0-16 7.164-16 16v152c0 8.836 7.164 16 16 16h56c6.061 0 11.601-3.424 14.311-8.845l19.578-39.155h300.223l19.578 39.155c2.71 5.421 8.25 8.845 14.311 8.845h56c8.837 0 16-7.164 16-16v-152c-.001-8.836-7.164-16-16.001-16zm-32-91.833c-11.449-7.679-25.209-12.167-40-12.167h-56v-32c0-35.29-28.71-64-64-64h-96c-35.29 0-64 28.71-64 64v32h-56c-14.791 0-28.551 4.488-40 12.167v-156.167h416zm-128-12.167h-160v-32c0-17.645 14.355-32 32-32h96c17.645 0 32 14.355 32 32zm-288 72c0-22.056 17.944-40 40-40h336c22.056 0 40 17.944 40 40v32h-416zm432 184h-30.111l-19.578-39.155c-2.71-5.421-8.25-8.845-14.311-8.845h-320c-6.061 0-11.601 3.424-14.311 8.845l-19.578 39.155h-30.111v-120h448z" />
                    </g>
                </svg>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label>{{ __('No. of single beds') }} <span class="text-danger">*</span></label>
                <input type="number" placeholder="{{ __('No. of single beds') }}" name="single_bed"
                    value="{{ $olteanu?->single_bed }}" class="form-control">
                <i>{{ __('Leave blank if you dont have this type of furniture.') }}</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="d-flex items-center mt-10">
                <svg fill="#000000" width="50px" height="50px" viewBox="0 0 512 512" class="ml-5"
                    id="Layer_1" enable-background="new 0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path
                            d="m496 320c0-13.1 0-239.28 0-248 0-8.836-7.164-16-16-16s-16 7.164-16 16v16h-416v-16c0-8.836-7.164-16-16-16s-16 7.164-16 16v248c-8.836 0-16 7.164-16 16v104c0 8.836 7.164 16 16 16h40c5.036 0 9.778-2.371 12.8-6.4l19.2-25.6h336l19.2 25.6c3.021 4.029 7.764 6.4 12.8 6.4h40c8.836 0 16-7.164 16-16v-104c0-8.836-7.164-16-16-16zm-32-71.39c-17.206-9.979-30.797-8.61-48-8.61v-32c0-26.467-21.533-48-48-48h-80c-12.284 0-23.501 4.644-32 12.261-8.499-7.617-19.716-12.261-32-12.261h-80c-26.467 0-48 21.533-48 48v32c-17.989 0-30.887-1.315-48 8.61v-128.61h416zm-336-8.61v-32c0-8.822 7.178-16 16-16h80c8.822 0 16 7.178 16 16v32zm144-32c0-8.822 7.178-16 16-16h80c8.822 0 16 7.178 16 16v32h-112zm-224 96c0-17.645 14.355-32 32-32h352c17.645 0 32 14.355 32 32v16h-416zm432 120h-16l-19.2-25.6c-3.021-4.029-7.764-6.4-12.8-6.4h-352c-5.036 0-9.778 2.371-12.8 6.4l-19.2 25.6h-16v-72h448z" />
                    </g>
                </svg>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <label>{{ __('No. of double beds') }} <span class="text-danger">*</span></label>
                <input type="number" placeholder="{{ __('No. of double beds') }}" name="double_bed"
                    value="{{ $olteanu?->double_bed }}" class="form-control">
                <i>{{ __('Leave blank if you dont have this type of furniture.') }}</i>
            </div>
        </div>
    </div>
    <hr>
    @if (is_default_lang())
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="control-label">{{ __('Minimum day stay requirements') }}</label>
                    <input type="number" name="min_day_stays" class="form-control"
                        value="{{ $row->min_day_stays }}" placeholder="{{ __('Ex: 2') }}">
                    <i>{{ __('Leave blank if you dont need to set minimum day stay option') }}</i>
                </div>
            </div>
        </div>
        <hr>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Number of beds') }} </label>
                <input type="number" value="{{ $row->beds ?? 1 }}" min="1" max="10"
                    placeholder="{{ __('Number') }}" name="beds" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Room Size') }} </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="size" value="{{ $row->size ?? 0 }}"
                        placeholder="{{ __('Room size') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">{!! size_unit_format() !!}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('Max Adults') }} </label>
                <input type="number" min="1" value="{{ $row->adults ?? 1 }}" name="adults"
                    class="form-control">
            </div>
        </div>
    </div>
    <hr>
    <script>
        var childrenElementCount = 1;

        function addKidPrices() {
            const default_el = document.getElementById('default_kid_in_room');
            const copy_el = default_el.cloneNode(true); // true parameter clones all child nodes as well

            const customId = 'customChildrenPrices_' + childrenElementCount;
            copy_el.setAttribute('id', customId);
            const deleteLink = copy_el.querySelector('.text-danger');
            deleteLink.setAttribute('href', `javascript:deleteChildrenPrices('${customId}')`);


            document.getElementById('kids_in_room').appendChild(copy_el);
            childrenElementCount += 1;
        }

        function deleteChildrenPrices(elId) {
            if (elId == "customChildrenPrices_0")
                return;
            document.getElementById(elId).innerHTML = '';
        }
    </script>
@endif
