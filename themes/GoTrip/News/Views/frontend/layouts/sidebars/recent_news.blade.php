<div class="sidebar-widget widget_bloglist">
    <div class="sidebar-title">
        <h2>{{ $item->title }}</h2>
    </div>
    <ul class="thumb-list">
        @php $list_blog = $model_news->with(['category','translation'])->orderBy('id','desc')->paginate(5) @endphp
        @if($list_blog)
            @foreach($list_blog as $blog)
                @php $translation = $blog->translate() @endphp
                <li>
                    @if($image_url = get_file_url($blog->image_id, 'thumb'))
                        <div class="thumb">
                            <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">
                                {!! get_image_tag($blog->image_id,'thumb',['class'=>'','alt'=>$blog->title,'lazy'=>false]) !!}
                            </a>
                        </div>
                    @endif
                    <div class="content">
                        @if(!empty($blog->category->name))
                            <div class="cate">
                                <a href="{{$blog->category->getDetailUrl()}}">
                                    @php $translation_cat = $blog->category->translate(); @endphp
                                    {{$translation_cat->name ?? ''}}
                                </a>
                            </div>
                        @endif
                        <h3 class="thumb-list-item-title">
                            <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">{{$translation->title}}</a>
                        </h3>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
