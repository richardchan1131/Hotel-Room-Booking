@php
    $terms_ids = $row->terms->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $attribute )
        @php $translate_attribute = $attribute['parent']->translate() @endphp
        @if(empty($attribute['parent']['hide_in_single']))
            @php $terms = $attribute['child'] @endphp
            <div class="{{$attribute['parent']->slug}} attr-{{$attribute['parent']->id}}">
                <h3 class="text-22 fw-500">{{ $translate_attribute->name }}</h3>
                <div class="row y-gap-10 pt-15 {{$attribute['parent']['display_type'] ?? ""}}">
                    @foreach($terms as $term )
                        @php $translate_term = $term->translate() @endphp
                        <div class="col-sm-5">
                            <div class="d-flex items-center item {{$term->slug}} term-{{$term->id}}">
                                @if(!empty($term->image_id))
                                    @php $image_url = get_file_url($term->image_id, 'full'); @endphp
                                    <img src="{{$image_url}}" class="img-responsive mr-15" alt="{{$translate_term->name}}">
                                @else
                                    <i class="{{ $term->icon ?? "icon-check" }} text-10 mr-15"></i>
                                @endif
                                <div class="text-15">{{$translate_term->name}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
@endif
