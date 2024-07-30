@if(setting_item('enable_cookie_consent'))
    @php $blocks_list = setting_item('cookie_consent_setting_modal_block_list');
    $cookie_blocks_data = [];
    if (!empty($blocks_list)){
        $blocks_list = json_decode($blocks_list);
        foreach ($blocks_list as $list){
            $data = [
                'title' => $list->title,
                'description' => $list->content
            ];
            if (!empty($list->toggle)){
                $data['toggle'] = [
                    'value' => $list->value,
                    'enabled' => (!empty($list->enable)),
                    'readonly' => (!empty($list->readonly))
                ];
            }
            $cookie_blocks_data[] = $data;
        }
    }
    @endphp
    <script defer src="{{asset('libs/cookie-consent/cookieconsent.js')}}"></script>
    <script>
        window.addEventListener('load', function () {

            // obtain plugin
            var cc = initCookieConsent();

            // run plugin with your configuration
            cc.run({
                current_lang: '{{ app()->getLocale() }}',
                autoclear_cookies: true,                   // default: false
                page_scripts: true,                        // default: false

                onFirstAction: function (user_preferences, cookie) {
                    // callback triggered only once on the first accept/reject action
                },

                onAccept: function (cookie) {
                    // callback triggered on the first accept/reject action, and after each page load
                },

                onChange: function (cookie, changed_categories) {
                    // callback triggered when user changes preferences after consent has already been given
                },

                languages: {
                    '{{ app()->getLocale() }}': {
                        consent_modal: {
                            title: '{{ setting_item('cookie_consent_title',__('We use cookies!')) }}',
                            description:'{!! clean(str_replace(array("\r", "\n"),'',setting_item('cookie_consent_desc'))) !!}',
                            primary_btn: {
                                text: '{{ setting_item('cookie_consent_primary_btn_text',__('Accept all')) }}',
                                role: '{{ setting_item('cookie_consent_primary_btn_text','accept_all') }}', // 'accept_selected' or 'accept_all'
                            },
                            secondary_btn: {
                                text: '{{ setting_item('cookie_consent_secondary_btn_text',__('Settings')) }}',
                                role: '{{ setting_item('cookie_consent_secondary_btn_text','settings') }}', // 'settings' or 'accept_necessary'
                            }
                        },
                        settings_modal: {
                            title: '{{ setting_item('cookie_consent_setting_modal_title',__('Cookie preferences')) }}',
                            save_settings_btn: '{{ setting_item('cookie_consent_setting_modal_save',__('Save settings')) }}',
                            accept_all_btn: '{{ setting_item('cookie_consent_setting_modal_accept',__('Accept all')) }}',
                            reject_all_btn: '{{ setting_item('cookie_consent_setting_modal_reject',__('Reject all')) }}',
                            close_btn_label: '{{__('Close')}}',
                            blocks: {!! json_encode($cookie_blocks_data) !!}
                        }
                    }
                }
            });
        });
    </script>
@endif

