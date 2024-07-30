<?php
$cat_ids = Request::query('cat_id');
$cat_name = "";
$list_cat_json = [];
$traverse = function ($categories, $prefix = '') use (&$traverse, &$list_cat_json , &$cat_name , $cat_ids) {
    foreach ($categories as $category) {
        $translate = $category->translate();
        if (!empty($cat_ids[0]) and $cat_ids[0] == $category->id){
            $cat_name = $translate->name;
        }
        $list_cat_json[] = [
            'id' => $category->id,
            'title' => $prefix . ' ' . $translate->name,
        ];
        $traverse($category->children, $prefix . '-');
    }
};
$traverse($event_category);
?>
<div class="searchMenu-loc pr-30 pl-20 lg:py-20 lg:px-0 js-form-dd js-liverSearch">
    <div lass="d-flex" data-x-dd-click="searchMenu-loc">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ __('Category') }}</h4>

        <div class="text-15 text-light-1 ls-2 lh-16">
            <input type="hidden" name="cat_id[]" class="js-search-get-id" value="{{ $cat_ids[0] ?? "" }}">
            <input autocomplete="off" type="search" placeholder="{{__("All Category")}}" class="js-search js-dd-focus" value="{{ $cat_name ?? '' }}" />
        </div>
    </div>
    <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc" data-x-dd-toggle="-is-active">
        <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
            <div class="y-gap-5 js-results">
                @foreach($list_cat_json as $oneCategory)
                    <div class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-id="{{ @$oneCategory['id'] }}">
                        <div class="d-flex align-items-center">
                            <div class="ml-10">
                                <div class="text-15 lh-12 fw-500 js-search-option-target">{{ @$oneCategory['title'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
