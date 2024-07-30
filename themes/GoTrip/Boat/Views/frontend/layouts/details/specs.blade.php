@if(!empty($translation->specs))
    <div class="col-12">
        <h5 class="text-16 fw-500">{{ __("About") }}</h5>
        <div class="list-item">
            @foreach($translation->specs as $item)
                <ul class="list-disc text-15 mt-10">
                    <li>{{ $item['title']  }}: {{ $item['content'] }}</li>
                </ul>
            @endforeach
        </div>
    </div>
@endif
