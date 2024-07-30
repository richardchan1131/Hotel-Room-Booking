@php
    $list_category = $model_category->with('translation')->get()->toTree();
@endphp
@if(!empty($list_category))
<div class="sidebar-widget widget_category">
    <div class="sidebar-title">
        <h2>{{ $item->title }}</h2>
    </div>
    <ul>
        <?php
        $traverse = function ($categories, $prefix = '') use (&$traverse) {
            foreach ($categories as $category) {
                $translation = $category->translate();
                ?>
                    <li>
                        <span></span>
                        <a href="{{ $category->getDetailUrl() }}">{{$prefix}} {{$translation->name}}</a>
                    </li>
                <?php
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse($list_category);
        ?>
    </ul>
</div>
@endif
