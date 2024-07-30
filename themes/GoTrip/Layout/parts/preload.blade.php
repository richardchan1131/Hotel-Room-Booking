<div class="preloader js-preloader @if(empty(setting_item('enable_preload'))) -is-hidden @endif">
    @if(!empty($logo_preload_id = setting_item('logo_preload_id')))
        <div class="preloader__wrap">
            <div class="preloader__icon">
                <img class="logo-light" src="{{get_file_url($logo_preload_id,'full')}}" alt="{{setting_item("site_title")}}">
            </div>
        </div>
    @endif
    <div class="preloader__title">{{ setting_item('site_title') }}</div>
</div>
