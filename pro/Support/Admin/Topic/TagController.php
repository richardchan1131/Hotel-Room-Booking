<?php

namespace Pro\Support\Admin\Topic;

use Illuminate\Http\Request;
use Modules\AdminController;
use Pro\Support\Models\Tag;

class TagController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('support.admin.topic.index'));
    }

    public function index(Request $request)
    {
        $this->checkPermission('support_topic_create');

        $tagname = $request->query('s');
        $taglist = Tag::query();
        if ($tagname) {
            $taglist->where('name', 'LIKE', '%' . $tagname . '%');
        }
        $taglist->orderby('name', 'asc');
        $data = [
            'rows'        => $taglist->paginate(20),
            'row'         => new Tag(),
            'breadcrumbs' => [
                [
                    'name' => __('Support'),
                    'url'  => route('support.admin.topic.index')
                ],
                [
                    'name'  => __('Tag'),
                    'class' => 'active'
                ],
            ],
        ];
        return view('Support::admin.topic.tag.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('support_topic_create');
        $row = Tag::find($id);
        if (empty($row)) {
            return redirect(route('support.admin.topic.tag.index'));
        }

        $data = [
            'row'               => $row,
            'enable_multi_lang' => true
        ];
        return view('Support::admin.topic.tag.detail', $data);
    }

    public function store(Request $request, $id)
    {

        $this->checkPermission('support_topic_create');

        if ($id > 0) {
            $row = Tag::find($id);
            if (empty($row)) {
                return redirect(route('support.admin.topic.tag.index'));
            }
        } else {
            $row = new Tag();
//            $row->status = "publish";
        }

        $row->fill($request->input());
        $res = $row->save();
        $row->saveSEO($request, $request->input('lang'));

        if ($res) {
            if ($id > 0) {
                return back()->with('success', __('Tag updated'));
            } else {
                return redirect(route('support.admin.topic.tag.index'))->with('success', __('Tag Created'));
            }
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('support_topic_create');
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
                $query = Tag::where("id", $id)->first();
                if (!empty($query)) {
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }
}
