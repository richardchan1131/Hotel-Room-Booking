@extends ('admin.layouts.app')
@section ('content')
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $hasAvailableTools = false;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between mb20">
                    <h1 class="title-bar">{{__('Tools')}}</h1>
                </div>
                @include('admin.message')
                <div class="panel">
                    <div class="panel-body pd15">
                        <div class="row area-setting-row">
                            @if($user->hasPermission('setting_update'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('core.admin.module.index')}}">
                                        <span class="setting-item-media">
                                            <i class="icon ion-md-color-wand"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title">{{__("Modules")}}</span>
                                            <span class="setting-item-desc">{{__("Modules for Booking Core")}}</span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermission('language_manage'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('language.admin.index')}}">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("Languages")}}</span>
                                                <span class="setting-item-desc">{{__("Manage languages of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermission('language_translation'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('language.admin.translations.index')}}">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("Translations")}}</span>
                                                <span class="setting-item-desc">{{__("Translation manager of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermission('system_log_view'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{url('admin/logs')}}">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title">{{__("System Log Viewer")}}</span>
                                                <span class="setting-item-desc">{{__("Views and manage system log of your website")}}</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if($user->hasPermission('system_log_view'))
                                @php $hasAvailableTools = true; @endphp
                                <div class="col-md-4 d-none">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('core.admin.updater.index')}}">
                                        <span class="setting-item-media">
                                            <i class="icon ion-ios-nuclear"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title">{{__("Updater")}}</span>
                                            <span class="setting-item-desc">{{__("Updater Booking Core")}}</span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="{{route('core.tool.clearCache')}}">
                                        <span class="setting-item-media">
                                            <i class="icon ion-ios-hammer"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title">{{__("Clear Cache")}}</span>
                                            <span class="setting-item-desc">{{__("Clear Cache for Booking Core")}}</span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            @if(!$hasAvailableTools)
                                <div class="col-md-12">
                                    {{__("No tools available")}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
