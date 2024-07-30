@extends('Layout::admin.empty')
@section('content')
    <div id="live-editor" class=" flex-column overflow-auto" v-cloak="">
        <div class="live-topbar flex-shrink-0 d-flex justify-content-between py-3 px-3 ">
            <div class="d-flex align-items-center">
                @if($refLink)
                    <a href="{{$refLink}}" class="px-3 lh-26 text-26 text-black border-right-1 border-right-solid border-right-gray mr-3">
                        <i
                            class="ion ion-ios-close-circle-outline"
                        ></i>
                    </a>
                @endif
                <h5 class="mb-0">{{$translation->title}}</h5>
                @if($refPreviewLink)
                    <a href="{{$refPreviewLink}}" target="_blank" class="ml-3 btn btn-sm btn-default">
                        <i
                            class="ion ion-ios-play-circle"
                        ></i>
                        {{__("Preview")}}
                    </a>
                @endif
            </div>
            <div>
            </div>
            <div>
                <span
                    class="alert-text mr-3"
                    v-show="message.content"
                    :class="message.type ? 'success' : 'danger'"
                >@{{message.content}}</span>
                @if(empty($row->id) and app()->getLocale() != setting_item('site_locale'))
                    {{__('You need to create the template at the Main-language tab first!')}}
                @else
                @endif
                <span class="last_saved font-italic" v-if="lastSaved"> {{__("Last saved:")}} @{{ lastSaved }}</span>
            </div>
        </div>
        <div class="d-flex flex-grow-1 position-relative overflow-auto">
            <div class="live-left-zone">
                @include('Template::admin.live.parts.layers')
                @include('Template::admin.live.parts.add-block')
            </div>
            <div class="live-content-zone">
                <iframe
                    id="frame-preview" src="{{route('template.preview',['template'=>$row,'preview'=>1])}}" width="100%" height="100%"
                    frameborder="0"
                ></iframe>
            </div>
            <div class="live-right-zone overflow-auto" v-if="selectedBlockId">
                <block-form
                    @save="saveBlock" @cancel="cancelEdit" :id="selectedBlockId" :current-model="currentModel" :on-saving="onSaving"
                    :current-block-setting="currentBlockSetting"
                />
            </div>
        </div>
    </div>
    <script>
        var current_template_items = {!! json_encode($translation->content_json) !!};
        var current_template_title = '{{$translation->title ?? ''}}';
        var current_last_saved = '{{display_datetime($row->updated_at)}}';
        var template_id = {{$row->id ?? 0}};
        var current_menu_lang = '{{request()->query('lang',app()->getLocale())}}';
        var template_i18n = {
            cancel: '{{__('Cancel')}}',
            save_changes: '{{__('Save changes')}}',
            delete_confirm: '{{__('Are you want to delete?')}}',
            add_new: '{{__('Add New')}}',
            save_block: '{{__('Save Block')}}',
        };
    </script>
@endsection

@push('css')
    <link
        rel="stylesheet"
        href="{{asset('dist/admin/module/template/admin/live/live.css?_v='.config('app.asset_version'))}}"
    />
    <link
        rel="stylesheet"
        href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css"
    >
@endpush
@push('js')
@endpush
