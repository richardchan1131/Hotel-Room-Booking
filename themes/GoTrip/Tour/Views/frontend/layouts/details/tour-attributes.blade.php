@php
    $terms_ids = $row->tour_term->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $key => $attribute )
        @php $translate_attribute = $attribute['parent']->translate() @endphp
        @if(empty($attribute['parent']['hide_in_single']))
            <div class="col-lg-4 col-md-6">
                <div class="fw-500 mb-10">{{ $translate_attribute->name }}</div>
                @php $terms = $attribute['child'] @endphp
                <ul class="list-disc">
                    @foreach($terms as $term )
                        @php $translate_term = $term->translate() @endphp
                        <li>
                            @if(!empty($term->image_id))
                                @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                <img src="{{$image_url}}" class="img-responsive" alt="{{$translate_term->name}}">
                            @else
                                @if($term->icon)
                                    <i class="{{ $term->icon }}"></i>
                                @endif
                            @endif
                            {{$translate_term->name}}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
@endif
