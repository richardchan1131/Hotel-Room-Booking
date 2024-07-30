<?php

namespace Pro\Support\Controllers\Topic;

use Modules\FrontendController;
use Pro\Support\Models\Topic;
use Pro\Support\Models\TopicCat;

class CategoryController extends FrontendController
{

    private TopicCat $cat;
    private Topic $topic;

    public function __construct(TopicCat $cat, Topic $topic)
    {
        parent::__construct();
        $this->cat = $cat;
        $this->topic = $topic;
    }

    public function index($slug)
    {

        $cat = $this->cat->whereSlug($slug)->whereStatus('publish')->first();
        if (!$cat) abort(404);
        $trans = $cat->translate();

        $query = $this->topic->search(array_merge(request()->query(), ['catId' => $cat->id]));

        $page_title = $trans->name;
        if (request('s')) {
            $page_title = __("Search result for: :name", ['name' => request('s')]);
        }
        $data = [
            'page_title' => $page_title,
            'rows'       => $query->paginate(20),
            'cat'        => $cat
        ];

        return view('Support::frontend.topic.index', $data);
    }
}
