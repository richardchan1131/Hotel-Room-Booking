@php
    $selected = (array) Request::query('attrs',[]);
@endphp
@foreach ($attributes as $item)
    @if(empty($item['hide_in_filter_search']))
        @php
            $translate = $item->translate();
        @endphp
        <div class="sidebar__item g-filter-item">
            <h5 class="text-18 fw-500 mb-10">{{$translate->name}}</h5>
            <div class="sidebar-checkbox ">
                @foreach($item->terms as $key => $term)
                    @php $translate = $term->translate(); @endphp
                    <div class="row y-gap-10 items-center justify-between @if($key > 2 and empty($selected[$item->slug])) hide @endif">
                        <div class="col-auto">
                            <label  class="cursor-pointer">
                                <div class="form-checkbox d-flex items-center">
                                    <input @if(in_array($term->slug,$selected[$item->slug] ?? [])) checked @endif type="checkbox" name="attrs[{{$item->slug}}][]" value="{{$term->slug}}">
                                    <div class="form-checkbox__mark">
                                        <div class="form-checkbox__icon icon-check"></div>
                                    </div>
                                    <div class="text-15 ml-10">{!! $translate->name !!}</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-auto">
                            <div class="text-15 text-light-1"></div>
                        </div>
                    </div>
                @endforeach
                @if(count($item->terms) > 3 and empty($selected[$item->slug]))
                    <button type="button" class="btn btn-link btn-more-item">{{__("More")}} <i class="fa fa-caret-down"></i></button>
                @endif
            </div>
        </div>
    @endif
@endforeach
