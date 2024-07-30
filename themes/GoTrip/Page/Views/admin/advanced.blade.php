<input type="hidden" name="save_footer_style" value="1">
<div class="panel">
    <div class="panel-title"><strong>{{__('Header Style')}}</strong></div>
    <div class="panel-body">
        <select name="header_style" class="form-control" >
            <option value="normal" {{ ( $row->header_style ?? '') == 'normal' ? 'selected' : ''  }}>{{__("Normal")}}</option>
            <option value="normal_white" {{( $row->header_style ?? '') == 'normal_white' ? 'selected' : ''  }}>{{__('Normal White')}}</option>
            <option value="transparent" {{( $row->header_style ?? '') == 'transparent' ? 'selected' : ''  }}>{{__('Transparent')}}</option>
            <option value="transparent_v2" {{( $row->header_style ?? '') == 'transparent_v2' ? 'selected' : ''  }}>{{__('Transparent V2')}}</option>
            <option value="transparent_v3" {{( $row->header_style ?? '') == 'transparent_v3' ? 'selected' : ''  }}>{{__('Transparent V3')}}</option>
            <option value="transparent_v4" {{( $row->header_style ?? '') == 'transparent_v4' ? 'selected' : ''  }}>{{__('Transparent V4')}}</option>
            <option value="transparent_v5" {{( $row->header_style ?? '') == 'transparent_v5' ? 'selected' : ''  }}>{{__('Transparent V5')}}</option>
            <option value="transparent_v6" {{( $row->header_style ?? '') == 'transparent_v6' ? 'selected' : ''  }}>{{__('Transparent V6')}}</option>
            <option value="transparent_v7" {{( $row->header_style ?? '') == 'transparent_v7' ? 'selected' : ''  }}>{{__('Transparent V7')}}</option>
            <option value="transparent_v8" {{( $row->header_style ?? '') == 'transparent_v8' ? 'selected' : ''  }}>{{__('Transparent V8')}}</option>
            <option value="transparent_v9" {{( $row->header_style ?? '') == 'transparent_v9' ? 'selected' : ''  }}>{{__('Transparent V9')}}</option>
        </select>
    </div>
</div>
<div class="panel">
    <div class="panel-title"><strong>{{ __('Footer Style') }}</strong></div>
    <div class="panel-body">
        <select name="footer_style" class="form-control">
            <option value="normal">{{ __('Normal') }}</option>
            <option value="style_1" @if($row->footer_style == 'style_1') selected @endif>{{ __('Style 1') }}</option>
            <option value="style_2" @if($row->footer_style == 'style_2') selected @endif>{{ __('Style 2') }}</option>
            <option value="style_3" @if($row->footer_style == 'style_3') selected @endif>{{ __('Style 3') }}</option>
            <option value="style_4" @if($row->footer_style == 'style_4') selected @endif>{{ __('Style 4') }}</option>
            <option value="style_5" @if($row->footer_style == 'style_5') selected @endif>{{ __('Style 5') }}</option>
            <option value="style_6" @if($row->footer_style == 'style_6') selected @endif>{{ __('Style 6') }}</option>
            <option value="style_7" @if($row->footer_style == 'style_7') selected @endif>{{ __('Style 7') }}</option>
            <option value="style_8" @if($row->footer_style == 'style_8') selected @endif>{{ __('Style 8') }}</option>
        </select>

        <label class="form-label mt-3">
            <input type="hidden" name="disable_subscribe_default" value="0">
            <input type="checkbox" name="disable_subscribe_default" @if(!empty($row->disable_subscribe_default)) checked @endif value="1">
            {{ __('Disable subscribe default') }}
        </label>
    </div>
</div>
