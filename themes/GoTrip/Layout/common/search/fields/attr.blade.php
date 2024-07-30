@if(!empty($field['attr']) and !empty($attr = \Modules\Core\Models\Attributes::find($field['attr'])))
    @php
        $attr_translate = $attr->translate();
        if(request()->query('term_id'))
            $selected = \Modules\Core\Models\Terms::find(request()->query('term_id'));
        else $selected = false;
        $list_cat_json = [];
    @endphp
    @if($attr)
        <div class="searchMenu-loc js-form-dd js-liverSearch item">
            <div data-x-dd-click="searchMenu-loc">
                <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] ?? "" }}</h4>
                <div class="text-15 text-light-1 ls-2 lh-16">
                    <input type="hidden" name="terms[]" class="js-search-get-id" value="{{Request::query('term_id')}}">
                    <input autocomplete="off" type="search" placeholder="{{__("All :name",['name'=>$attr_translate->name])}}" class="js-search js-dd-focus" value="{{ $selected ? $selected->name ?? '' :'' }}" />
                </div>
            </div>
            <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
                <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                    <div class="y-gap-5 js-results">
                        @foreach($attr->terms as $term)
                            @php $translate = $term->translate();
                                $list_cat_json[] = [
                                    'id' => $term->id,
                                    'title' => $translate->name,
                                ];
                            @endphp
                            <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-id="{{ $term->id }}">
                                <div class="d-flex align-items-center">
                                    <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                                    <div class="ml-10">
                                        <div class="text-15 lh-12 fw-500 js-search-option-target">{{ $translate->name }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    @endif
@endif
