@php
    $terms_ids = $row->terms->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $attribute )
        @php $translate_attribute = $attribute['parent']->translate() @endphp
        @if(empty($attribute['parent']['hide_in_single']))
            <div class="col-12 g-attributes {{$attribute['parent']->slug}} attr-{{$attribute['parent']->id}}">
                <h5 class="d-flex items-center text-16 fw-500">
                    {{ $translate_attribute->name }}
                </h5>
                @php $terms = $attribute['child'] @endphp
                <div class="list-disc row x-gap-40 text-15 mt-10 {{$attribute['parent']['display_type'] ?? ""}}">
                    @foreach($terms as $term )
                        @php $translate_term = $term->translate() @endphp
                        <div class="item col-md-3 col-6 {{$term->slug}} term-{{$term->id}}">
                            @if(!empty($term->image_id))
                                @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                <img src="{{$image_url}}" class="img-responsive" alt="{{$translate_term->name}}">
                            @else
                                <i class="{{ $term->icon ?? "icofont-check-circled icon-default" }}"></i>
                            @endif
                            {{$translate_term->name}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @endforeach
@endif
