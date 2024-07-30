<div class="searchMenu-date form-date-search-hotel position-relative item">
    <div data-x-dd-click="searchMenu-loc">
        <h4 class="text-15 fw-500 ls-2 lh-16">{{ $field['title'] }}</h4>
        <div class="text-15 text-light-1 ls-2 lh-16">
            <input type="text" name="service_name" placeholder="{{ __('Search for...') }}" class="js-search js-dd-focus" value="{{ request()->input("service_name") }}" />
        </div>
    </div>
</div>
