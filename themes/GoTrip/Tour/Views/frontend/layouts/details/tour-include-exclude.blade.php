@php
    if(!empty($translation->include)){
        $title = __("Included");
    }
    if(!empty($translation->exclude)){
        $title = __("Excluded");
    }
    if(!empty($translation->exclude) and !empty($translation->include)){
        $title = __("Included/Excluded");
    }
@endphp
@if(!empty($title))
    <h3 class="text-22 fw-500">{{ $title }}</h3>

    <div class="row x-gap-40 y-gap-40 pt-20">
        @if($translation->include)
            <div class="col-md-6">
                @foreach($translation->include as $item)
                    <div class="text-dark-1 text-15">
                        <i class="icon-check text-10 mr-10"></i> {{$item['title']}}
                    </div>
                @endforeach
            </div>
        @endif

        @if($translation->exclude)
            <div class="col-md-6">
                @foreach($translation->exclude as $item)
                    <div class="text-dark-1 text-15">
                        <i class="icon-close text-green-2 text-10 mr-10"></i> {{$item['title']}}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
