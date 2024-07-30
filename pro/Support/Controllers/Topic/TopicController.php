<?php

namespace Pro\Support\Controllers\Topic;

use Modules\FrontendController;
use Pro\Support\Models\Topic;

class TopicController extends FrontendController
{

    private Topic $topic;

    public function __construct(Topic $topic)
    {
        parent::__construct();
        $this->topic = $topic;
    }

    public function index()
    {
        $query = $this->topic->search(request()->query());
        $page_title = __('All Topics');
        if (request('s')) {
            $page_title = __("Search result for: :name", ['name' => request('s')]);
        }
        $data = [
            'page_title' => $page_title,
            'rows'       => $query->paginate(20),
        ];

        return view('Support::frontend.topic.index', $data);
    }

    public function detail($slug)
    {
        $topic = $this->topic->whereSlug($slug)->whereStatus('publish')->first();
        if (!$topic) abort(404);
        $trans = $topic->translate();
        $topic->views += 1;
        $topic->save();

        $data = [
            'page_title'  => $trans->title,
            'row'         => $topic,
            'translation' => $trans
        ];

        return view('Support::frontend.topic.detail', $data);
    }
}
