<?php

namespace Pro\Support\Admin\Topic;

use Illuminate\Http\Request;
use Modules\AdminController;
use Pro\Support\Models\TopicCat;
use Pro\Support\Models\TopicCatTranslation;

class CategoryController extends AdminController
{
    private TopicCat $cat;
    private TopicCatTranslation $catTranslation;

    public function __construct(TopicCat $cat, TopicCatTranslation $catTranslation)
    {
        $this->setActiveMenu(route('support.admin.topic.index'));
        $this->cat = $cat;
        $this->catTranslation = $catTranslation;
    }

    public function index(Request $request)
    {
        $this->checkPermission('support_topic_category');

        $catlist = new $this->cat;
        if ($catename = $request->query('s')) {
            $catlist = $catlist->where('name', 'LIKE', '%' . $catename . '%');
        }

        $catlist = $catlist->orderby('name', 'asc');
        $rows = $catlist->get();

        $data = [
            'rows'        => $rows->toTree(),
            'row'         => new $this->cat(),
            'page_title'  => __("Manage category"),
            'breadcrumbs' => [
                [
                    'name' => __('Topic'),
                    'url'  => route('support.admin.topic.index')
                ],
                [
                    'name'  => __('Category'),
                    'class' => 'active'
                ],
            ],
            'translation' => new $this->catTranslation()
        ];
        return view('Support::admin.topic.category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('support_topic_category');
        $row = $this->cat::find($id);

        $translation = $row->translate($request->query('lang', get_main_lang()));

        if (empty($row)) {
            return redirect(route('support.admin.topic.category.index'));
        }
        $data = [
            'row'               => $row,
            'translation'       => $translation,
            'parents'           => $this->cat::get()->toTree(),
            'enable_multi_lang' => true,
            'page_title'        => __("Edit category")
        ];
        return view('Support::admin.topic.category.detail', $data);
    }

    public function store(Request $request, $id)
    {
        $this->checkPermission('support_topic_category');
        $request->validate([
            'name' => 'required'
        ]);

        if ($id > 0) {
            $row = $this->cat::find($id);
            if (empty($row)) {
                return redirect(route('support.admin.topic.category.index'));
            }
        } else {
            $row = new $this->cat();
            $row->status = "publish";
        }

        $row->fill($request->input());
        $row->display_order = $request->input('display_order');
        $row->image_id = $request->input('image_id');

        $res = $row->saveOriginOrTranslation($request->input('lang'));

        if ($res) {
            if ($id > 0) {
                return back()->with('success', __('Category updated'));
            } else {
                return redirect(route('support.admin.topic.category.index'))->with('success', __('Category created'));
            }
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('support_topic_category');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Please select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an Action!'));
        }
        if ($action == 'delete') {
            foreach ($ids as $id) {
                $query = $this->cat::where("id", $id)->first();
                if (!empty($query)) {
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if ($pre_selected && $selected) {
            $item = $this->cat::find($selected);
            if (empty($item)) {
                return response()->json([
                    'text' => ''
                ]);
            } else {
                return response()->json([
                    'text' => $item->name
                ]);
            }
        }
        $q = $request->query('q');
        $query = $this->cat::select('id', 'name as text')->where("status", "publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
