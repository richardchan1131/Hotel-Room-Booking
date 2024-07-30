<div class="context" @if(!empty($bg_image_url)) style="background-image: url({{ $bg_image_url ?? "" }}) !important;" @endif>
    <div class="container">
        <div class="title">
            {{$title}}
        </div>
        <div class="sub_title">
            {{$sub_title}}
        </div>
        @if($link_title)
            <a class="btn-more" href="{{$link_more}}">
                {{$link_title}}
            </a>
        @endif
    </div>
</div>