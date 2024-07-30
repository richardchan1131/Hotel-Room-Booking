<?php

namespace Pro\Support\Controllers\Topic;

use Modules\FrontendController;
use Pro\Support\Models\Tag;
use Pro\Support\Models\Topic;

class TagController extends FrontendController
{

    private Topic $topic;
    private Tag $tag;

    public function __construct(Tag $tag, Topic $topic)
    {
        parent::__construct();
        $this->topic = $topic;
        $this->tag = $tag;
    }

    public function index($slug)
    {

        $tag = $this->tag->whereSlug($slug)->first();
        if (!$tag) abort(404);
        $trans = $tag;

        $query = $this->topic->search(array_merge(request()->query(), ['tagId' => $tag->id]));

        $page_title = $trans->name;
        if (request('s')) {
            $page_title = __("Search result for: :name", ['name' => request('s')]);
        }
        $data = [
            'page_title' => $page_title,
            'rows'       => $query->paginate(20),
            'cat'        => $tag
        ];

        return view('Support::frontend.topic.index', $data);
    }
}
