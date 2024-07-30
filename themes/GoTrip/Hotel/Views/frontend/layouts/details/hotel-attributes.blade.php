@php
    $terms_ids = $row->terms->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $key => $attribute )
        @php $translate_attribute = $attribute['parent']->translate() @endphp
        @if(empty($attribute['parent']['hide_in_single']))
            <div class="g-attributes {{$attribute['parent']->slug}} attr-{{$attribute['parent']->id}} pb-30">
                @php $terms = $attribute['child'] @endphp
                <h3 class="text-22 fw-500 pt-40 border-top-light mb-20">{{ $translate_attribute->name }}</h3>
                <div class="list-attributes d-flex flex-wrap">
                    @foreach($terms as $term )
                        @php $translate_term = $term->translate() @endphp
                        <div class="item {{$term->slug}} term-{{$term->id}}">
                            @if(!empty($term->image_id))
                                @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                <img src="{{$image_url}}" class="img-responsive" alt="{{$translate_term->name}}">
                            @else
                                <i class="{{ $term->icon ?? "icon-check text-blue-1" }}"></i>
                            @endif
                            {{$translate_term->name}}</div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
@endif
<div class="border-bottom-light"></div>
