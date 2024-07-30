<script>
    var bookingCore = {
        url:'{{url( app_get_locale() )}}',
        url_root:'{{ url('') }}',
        admin_url:'{{ route('admin.index') }}',
        booking_decimals:{{(int)get_current_currency('currency_no_decimal',2)}},
        thousand_separator:'{{get_current_currency('currency_thousand')}}',
        decimal_separator:'{{get_current_currency('currency_decimal')}}',
        currency_position:'{{get_current_currency('currency_format')}}',
        currency_symbol:'{{currency_symbol()}}',
        currency_rate:'{{get_current_currency('rate',1)}}',
        date_format:'{{get_moment_date_format()}}',
        map_provider:'{{setting_item('map_provider')}}',
        map_gmap_key:'{{setting_item('map_gmap_key')}}',
        map_options:{
            map_lat_default:'{{setting_item('map_lat_default')}}',
            map_lng_default:'{{setting_item('map_lng_default')}}',
            map_clustering: {{setting_item('map_clustering') ? 'true' : 'false'}},
            map_fit_bounds: {{setting_item('map_fit_bounds') ? 'true': 'false'}},
        },
        routes:{
            login:'{{route('login')}}',
            register:'{{route('auth.register')}}',
            checkout:'{{is_api() ? route('api.booking.doCheckout') : route('booking.doCheckout')}}'
        },
        currentUser: {{(int)Auth::id()}},
        isAdmin : {{is_admin() ? 1 : 0}},
        rtl: {{ setting_item_with_lang('enable_rtl') ? "true" : "false" }},
        markAsRead:'{{route('core.notification.markAsRead')}}',
        markAllAsRead:'{{route('core.notification.markAllAsRead')}}',
        loadNotify : '{{route('core.notification.loadNotify')}}',
        pusher_api_key : '{{setting_item("pusher_api_key")}}',
        pusher_cluster : '{{setting_item("pusher_cluster")}}',
        language: '{{ app()->getLocale() }}',
        module:{}
    };
    @if(auth()->user())
        bookingCore.media = {
        groups:{!! json_encode(config('bc.media.groups')) !!},
    }
    @endif
    @foreach(get_bookable_services() as $id=>$class)
        @if($class::isEnable())
            bookingCore.module.{{$id}} = '{{route($id.'.search')}}';
        @endif
    @endforeach
    var i18n = {
        warning:"{{__("Warning")}}",
        success:"{{__("Success")}}",
        confirm_delete:"{{__("Do you want to delete?")}}",
        confirm:"{{__("Confirm")}}",
        cancel:"{{__("Cancel")}}",
    };
    var daterangepickerLocale = {
        "applyLabel": "{{__('Apply')}}",
        "cancelLabel": "{{__('Cancel')}}",
        "fromLabel": "{{__('From')}}",
        "toLabel": "{{__('To')}}",
        "customRangeLabel": "{{__('Custom')}}",
        "weekLabel": "{{__('W')}}",
        "first_day_of_week": {{ setting_item("site_first_day_of_the_weekin_calendar","1") }},
        "daysOfWeek": [
            "{{__('Su')}}",
            "{{__('Mo')}}",
            "{{__('Tu')}}",
            "{{__('We')}}",
            "{{__('Th')}}",
            "{{__('Fr')}}",
            "{{__('Sa')}}"
        ],
        "monthNames": [
            "{{__('January')}}",
            "{{__('February')}}",
            "{{__('March')}}",
            "{{__('April')}}",
            "{{__('May')}}",
            "{{__('June')}}",
            "{{__('July')}}",
            "{{__('August')}}",
            "{{__('September')}}",
            "{{__('October')}}",
            "{{__('November')}}",
            "{{__('December')}}"
        ],
    };
    window.currentUrl = '{{request()->url()}}';
</script>
