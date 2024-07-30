@php $selected = (array) Request::query('attrs',[]); @endphp
@foreach ($attributes as $item)
    @if(empty($item['hide_in_filter_search']))
        @php $translate = $item->translate();
                $term_label = $translate->name;

        $selected_attr = $selected[$item->id] ?? [];
        $selected_term = !empty($selected_attr[0]) ? $item->terms->where('id',$selected_attr[0])->first() : null;
        @endphp
        <div class="col-auto terms-item">
            <div class="dropdown js-dropdown js-{{$item->slug}}-active">
                <div class="dropdown__button d-flex items-center text-14 rounded-100 border-light px-15 h-34" data-el-toggle=".js-{{$item->slug}}-toggle" data-el-toggle-active=".js-{{$item->slug}}-active">
                    <span class="js-dropdown-title">{{$selected_term ? $selected_term->name : $translate->name}}</span>
                    <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                </div>
                <div class="toggle-element -dropdown js-click-dropdown js-{{$item->slug}}-toggle">
                    <div class="text-15 y-gap-15 js-dropdown-list">
                        <div class="border-bottom border-bottom-light"><a href="#" data-term="" class="d-block js-dropdown-link term-item ">{{$term_label}}</a></div>
                        @foreach($item->terms as $key => $term)
                            @php $translate = $term->translate(); @endphp
                            <div><a href="#" data-term="{{$term->id}}" class="d-block js-dropdown-link term-item">{{$translate->name}}</a></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <input type="hidden" class="terms" name="attrs[{{$item->id}}][]" value="">
        </div>
    @endif
@endforeach
