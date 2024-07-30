@if(!empty($field['attr']) and !empty($attr = \Modules\Core\Models\Attributes::find($field['attr'])))
    @php
        $attr_translate = $attr->translate();
        if(request()->query('term_id'))
            $selected = \Modules\Core\Models\Terms::find(request()->query('term_id'));
        else $selected = false;
        $list_cat_json = [];
    @endphp
    @if($attr)
        <div class="col-auto">

            <div class="dropdown js-dropdown js-attr-active">
                <div class="dropdown__button d-flex items-center text-14 rounded-100 border-light px-15 h-34" data-el-toggle=".js-attr-toggle" data-el-toggle-active=".js-attr-active">
                    <span class="js-dropdown-title">{{__('Attribute')}}</span>
                    <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                </div>

                <div class="toggle-element -dropdown js-click-dropdown js-attr-toggle">
                    <div class="text-15 y-gap-15 js-dropdown-list">

                        @foreach($attr->terms as $term)
                            @php $translate = $term->translate();
                        $list_cat_json[] = [
                            'id' => $term->id,
                            'title' => $translate->name,
                        ];
                            @endphp
                        @endforeach
                            <div class="smart-search">
                                <input type="text" class="smart-select parent_text form-control" readonly placeholder="{{__("All :name",['name'=>$attr_translate->name])}}" value="{{ $selected ? $selected->name ?? '' :'' }}" data-default="{{ json_encode($list_cat_json) }}">
                                <input type="hidden" class="child_id" name="terms[]" value="{{Request::query('term_id')}}">
                            </div>

                    </div>
                </div>
            </div>

        </div>
    @endif
@endif

