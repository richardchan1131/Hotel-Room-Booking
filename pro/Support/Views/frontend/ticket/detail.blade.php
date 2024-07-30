@extends('Layout::app')
@push('css')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/support/css/support.css?_v='.config('app.asset_version'))}}">
@endpush
@section('content')
    @include('Support::frontend.layouts.topic.search-form')

    <div class="topic-lists-wrap topic-detail mb-5">
        <div class="container">
            @include('Layout::parts.bc')
            <div class="row mt-4">
                <div class="col-md-9">
                    @include('admin.message')
                    <div class="page-header">
                        <h1 class="text-24">
                            <i class="fa fa-file-text-o"></i>
                            {{$page_title}}</h1>
                        <div class="ml-3 mt-2 topic-meta">
                            @if(!empty($is_agent))
                                <span>
                                    <i class="fa fa-user-o mr-1"></i> {{$row->customer->display_name ?? ''}}
                                </span>
                            @endif
                            @if($row->cat)
                                @php $cat_trans = $row->cat->translate() @endphp
                                <span class="mr-3">
                                    <i class="fa fa-folder-o mr-1"></i>
                                    <a href="{{$row->cat->getDetailUrl()}}">{{$cat_trans->name ?? ''}}</a>
                                </span>
                            @endif
                            @if($row->created_at)
                                <span>
                                    <i class="fa fa-clock-o"></i> {{human_time_diff(strtotime($row->created_at))}} ago
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="topic-content py-4">
                        {!! clean($row->content) !!}
                    </div>
                    <hr>
                    @include('Support::frontend.layouts.ticket.replies')
                </div>
                <div class="col-md-3">
                    @include('Support::frontend.layouts.ticket.detail-sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $('#current_time').html(moment().format('hh:mm:ss A'));
        var options = {
            menubar: false,
            plugins: 'image link codesample table hr lists',
            toolbar: 'bold italic strikethrough permanentpen formatpainter | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pagebreak codesample code | removeformat',
            image_advtab: false,
            image_caption: false,
            toolbar_drawer: 'sliding',
            relative_urls: false,
            height: 400,
            file_picker_types: 'image',
            paste_data_images: true,
            images_upload_handler: function(blobInfo, success, failure) {

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('is_private', 1);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: '{{route('media.store')}}',
                    data: formData,
                    dataType: 'json',
                    method: 'post',
                    processData: false,
                    contentType: false,
                    success: function(json) {
                        success(json.url);
                    },
                });
            },
        };
        var tmp = Object.assign({}, options);
        tmp.selector = '#reply_content2';
        tinymce.init(tmp);

        $('#reply_submit_btn2').on('click', function() {
            tinymce.activeEditor.uploadImages(function(success) {
                var myContent = tinymce.activeEditor.getContent();
                if (!myContent) {
                    $('#reply_content_invalid').show();
                    return;
                }
                document.getElementById('reply_form2').submit();
            });
        });
    </script>
@endpush
