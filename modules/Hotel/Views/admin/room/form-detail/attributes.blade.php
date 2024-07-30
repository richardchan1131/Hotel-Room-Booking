@if(is_default_lang())
    <div class="row">
        @foreach ($attributes as $attribute)
            @php $translate = $attribute->translate(app_get_locale()); @endphp
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label"><strong>{{__('Attribute: :name',['name'=>$translate->name])}}</strong></label>
                    <div class="terms-scrollable">
                        @foreach($attribute->terms as $term)
                            @php $term_translate = $term->translate(app_get_locale()); @endphp
                            <label class="term-item">
                                <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}">
                                <span class="term-name">{{$term_translate->name}}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr>
@endif
