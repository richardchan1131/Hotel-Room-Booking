<div class="topic-sidebars list-cats widget_category">
    <a
        href="{{route('support.ticket.index')}}"
        class="mb-4 btn-block btn btn-primary btn-lg">
        <i class="fa fa-question-circle-o"></i> {{__("Support tickets")}}</a>
    <div class="widget mb-5">
        <div class="widget-title">
            <h4>{{__("Categories")}}</h4>
        </div>
        <ul>
            <li>
                <a href="{{route('support.topic.index')}}">
                    <span></span> {{__("All categories")}}</a>
            </li>
            <?php
            $categories = \Pro\Support\Models\TopicCat::query()->with('translation')->get()->toTree();
            $traverse = function ($categories, $prefix = '') use (&$traverse) {
                foreach ($categories as $category) {
                    $trans = $category->translate();
                    $selected = '';
                    printf("<li class='%s' ><a href='%s'><span></span> %s</a></li>", $selected ? 'selected' : '', $category->getDetailUrl(), $prefix . ' ' . $trans->name);
                    $traverse($category->children, $prefix . '-');
                }
            };
            $traverse($categories);
            ?>
        </ul>
    </div>
    <div class="widget list-topics  mb-5">
        <div class="widget-title ">
            <h4>{{__("Popular Topics")}}</h4>
        </div>
        <div class="">
            <?php
            $topics = \Pro\Support\Models\Topic::query()->orderByDesc('views')->orderByDesc('id')->limit(10)->with('translation')->get();
            ?>
            @foreach($topics as $topic)
                    <?php $tran = $topic->translate() ?>
                <a
                    class="topic mb-2 d-flex justify-content-between mb-2 pb-2"
                    href="{{$topic->getDetailUrl()}}">
                    {{$tran->title}}
                    @if($topic->views)
                        <span>
                            <span class="badge badge-pill badge-light">{{$topic->views}}</span>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
