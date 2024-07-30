<?php

namespace Pro\Support\Admin\Topic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Language\Models\Language;
use Pro\Support\Models\Topic;
use Pro\Support\Models\TopicCat;
use Pro\Support\Models\TopicTranslation;

class TopicController extends AdminController
{
    private TopicCat $cat;
    private Topic $topic;

    public function __construct(TopicCat $cat, Topic $topic)
    {
        $this->setActiveMenu(route('support.admin.topic.index'));
        $this->cat = $cat;
        $this->topic = $topic;
    }

    public function index(Request $request)
    {
        $this->checkPermission('support_topic_view');
        $dataSupport = $this->topic->query()->orderBy('id', 'desc');
        $post_name = $request->query('s');
        $cate = $request->query('cat_id');
        if ($cate) {
            $dataSupport->where('cat_id', $cate);
        }
        if ($post_name) {
            $dataSupport->where('title', 'LIKE', '%' . $post_name . '%');
            $dataSupport->orderBy('title', 'asc');
        }

        $data = [
            'rows'        => $dataSupport->with("author")->with(['cat'])->paginate(20),
            'categories'  => $this->cat->get()->toTree(),
            'breadcrumbs' => [
                [
                    'name' => __('Topics'),
                    'url'  => route('support.admin.topic.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            "languages"   => Language::getActive(false),
            'page_title'  => __("Topic Management")
        ];
        return view('Support::admin.topic.index', $data);
    }

    public function clone($id)
    {
        $a = $this->topic->find($id);
        $b = $a->replicate();
        $b->title .= ' Copy';

        $b->status = 'draft';

        $b->save();

        return back()->with('success', __("Duplicated"));
    }

    public function create(Request $request)
    {
        $this->checkPermission('support_topic_create');
        $row = new $this->topic;
        $row->fill([
            'status' => 'publish',
        ]);
        $data = [
            'categories'  => $this->cat->get()->toTree(),
            'row'         => $row,
            'breadcrumbs' => [
                [
                    'name' => __('Support'),
                    'url'  => 'admin/module/knowleagebase'
                ],
                [
                    'name'  => __('Add Support'),
                    'class' => 'active'
                ],
            ],
            'translation' => new TopicTranslation()
        ];
        return view('Support::admin.topic.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('support_topic_update');

        $row = $this->topic->find($id);
        if (!$row) abort(404);

        $translation = $row->translate($request->query('lang'));

        if (empty($row)) {
            return redirect(route('support.admin.topic.index'));
        }

        $data = [
            'row'               => $row,
            'translation'       => $translation,
            'categories'        => $this->cat->get()->toTree(),
            'tags'              => $row->tags,
            'enable_multi_lang' => true
        ];
        return view('Support::admin.topic.detail', $data);
    }

    public function store(Request $request, $id)
    {
        if ($id > 0) {
            $this->checkPermission('support_topic_update');
            $row = $this->topic->find($id);
            if (empty($row)) {
                return redirect(route('support.admin.topic.index'));
            }
        } else {
            $this->checkPermission('support_topic_create');
            $row = new $this->topic();
            $row->status = "publish";
            $row->author_id = \auth()->id();
        }

        $row->fill($request->input());
        $row->display_order = $request->input('display_order');

        $res = $row->saveOriginOrTranslation($request->query('lang'), true);

        if ($res) {
            if (is_default_lang($request->query('lang'))) {
                $row->saveTag($request->input('tag_name'), $request->input('tag_ids'));
            }
            if ($id > 0) {
                return back()->with('success', __('Support updated'));
            } else {
                return redirect(route('support.admin.topic.edit', $row->id))->with('success', __('Topic created'));
            }
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('support_topic_update');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $this->topic->where("id", $id);
                if (!$this->hasPermission('support_topic_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('support_topic_delete');
                }
                $query->first();
                if (!empty($query)) {
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->topic->where("id", $id);
                if (!$this->hasPermission('support_topic_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('support_topic_update');
                }
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function trans($id, $locale)
    {
        $row = $this->topic->find($id);

        if (empty($row)) {
            return redirect()->back()->with("danger", __("Support does not exists"));
        }

        $translated = $this->topic->query()->where('origin_id', $id)->where('lang', $locale)->first();
        if (!empty($translated)) {
            redirect($translated->getEditUrl());
        }

        $language = Language::where('locale', $locale)->first();
        if (empty($language)) {
            return redirect()->back()->with("danger", __("Language does not exists"));
        }

        $new = $row->replicate();

        if (!$row->origin_id) {
            $new->origin_id = $row->id;
        }

        $new->lang = $locale;

        $new->save();


        return redirect($new->getEditUrl());
    }
}
