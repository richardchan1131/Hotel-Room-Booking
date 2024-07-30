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
                <a href="{{route('support.ticket.index')}}">
                    <span></span> {{__("All categories")}}</a>
            </li>
            <?php
            $categories = \Pro\Support\Models\TicketCat::query()->with('translation')->get()->toTree();
            $traverse = function ($categories, $prefix = '') use (&$traverse) {
                foreach ($categories as $category) {
                    $trans = $category->translate();
                    $selected = '';
                    $url = route('support.ticket.index', ['catId' => $category->id]);
                    printf("<li class='%s' ><a href='%s'><span></span> %s</a></li>", $selected ? 'selected' : '', $url, $prefix . ' ' . $trans->name);
                    $traverse($category->children, $prefix . '-');
                }
            };
            $traverse($categories);
            ?>
        </ul>
    </div>
</div>
