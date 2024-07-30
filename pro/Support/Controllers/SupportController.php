<?php

namespace Pro\Support\Controllers;

use Modules\FrontendController;
use Pro\Support\Models\TopicCat;

class SupportController extends FrontendController
{
    private TopicCat $cat;

    public function __construct(TopicCat $cat)
    {
        parent::__construct();
        $this->cat = $cat;

    }

    public function index()
    {
        $data = [
            'page_title' => __("Support Center"),
            'cats'       => $this->cat::query()->whereNull('parent_id')->orderBy('display_order')->orderByDesc('id')->where('status', 'publish')->with('translation')->get()
        ];

        return view("Support::frontend.index", $data);
    }
}
