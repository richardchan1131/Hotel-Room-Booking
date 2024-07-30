<div class="effect background-video-container">
    @if(!empty($video_url))
        @php $video_id = handleVideoUrl($video_url,true) @endphp
        <iframe class="background-video-embed" frameborder="0" src="https://www.youtube.com/embed/{{ $video_id }}?controls=0&autoplay=1&mute=1&playsinline=1&playlist={{ $video_id }}&loop=1"></iframe>
    @endif
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-heading">{{$title}}</h1>
            <div class="sub-heading">{{$sub_title}}</div>
            @include("Template::frontend.blocks.form-search-all-service.form-search")
        </div>
    </div>
</div>
