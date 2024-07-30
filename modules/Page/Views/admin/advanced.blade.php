<div class="panel">
    <div class="panel-title"><strong>{{__('Header Style')}}</strong></div>
    <div class="panel-body">
        <select name="header_style" class="form-control" >
            <option value="normal" {{ ( $row->header_style ?? '') == 'normal' ? 'selected' : ''  }}>{{__("Normal")}}</option>
            <option value="transparent" {{( $row->header_style ?? '') == 'transparent' ? 'selected' : ''  }}>{{__('Transparent')}}</option>
        </select>
    </div>
</div>
