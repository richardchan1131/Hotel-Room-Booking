@if(!empty($field['attr']) and !empty($attr = \Modules\Core\Models\Attributes::find($field['attr'])))
    @php
        $selected = (array) Request::query('terms');
    @endphp
    @if($attr)
        <h5 class="text-18 fw-500 mb-10">{{ $field['title'] ?? "" }}</h5>

        <div class="sidebar-checkbox">
            @foreach($attr->terms as $term)
                @php
                    $translate = $term->translate();
                @endphp
                <div class="row y-gap-10 items-center justify-between">
                    <div class="col-auto">
                        <div class="d-flex items-center">
                            <div class="form-checkbox ">
                                <input type="checkbox" name="terms[]" id="term_{{ $term->id }}" value="{{ $term->id }}" @if(!empty($selected) && in_array($term->id, $selected)) checked @endif>
                                <div class="form-checkbox__mark">
                                    <div class="form-checkbox__icon icon-check"></div>
                                </div>
                            </div>

                            <label class="text-15 ml-10" for="term_{{ $term->id }}">{{ $translate->name }}</label>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
@endif
