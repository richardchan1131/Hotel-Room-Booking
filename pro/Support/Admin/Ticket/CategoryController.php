<?php

namespace Pro\Support\Admin\Ticket;

use Illuminate\Http\Request;
use Modules\AdminController;
use Pro\Support\Models\TicketCat;
use Pro\Support\Models\TicketCatTranslation;

class CategoryController extends AdminController
{
    private TicketCat $cat;
    private TicketCatTranslation $catTranslation;

    public function __construct(TicketCat $cat, TicketCatTranslation $catTranslation)
    {
        $this->setActiveMenu(route('support.admin.ticket.index'));
        $this->cat = $cat;
        $this->catTranslation = $catTranslation;
    }

    public function index(Request $request)
    {
        $this->checkPermission('support_ticket_category');

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
                    'name' => __('Tickets'),
                    'url'  => route('support.admin.ticket.index')
                ],
                [
                    'name'  => __('Category'),
                    'class' => 'active'
                ],
            ],
            'translation' => new $this->catTranslation()
        ];
        return view('Support::admin.ticket.category.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('support_ticket_category');
        $row = $this->cat::find($id);

        $translation = $row->translate($request->query('lang', get_main_lang()));

        if (empty($row)) {
            return redirect(route('support.admin.ticket.category.index'));
        }
        $data = [
            'row'               => $row,
            'translation'       => $translation,
            'parents'           => $this->cat::get()->toTree(),
            'enable_multi_lang' => true,
            'page_title'        => __("Edit category")
        ];
        return view('Support::admin.ticket.category.detail', $data);
    }

    public function store(Request $request, $id)
    {
        $this->checkPermission('support_ticket_category');
        $request->validate([
            'name' => 'required'
        ]);

        if ($id > 0) {
            $row = $this->cat::find($id);
            if (empty($row)) {
                return redirect(route('support.admin.ticket.category.index'));
            }
        } else {
            $row = new $this->cat();
            $row->status = "publish";
        }

        $row->fill($request->input());
        $row->display_order = $request->input('display_order');

        $res = $row->saveOriginOrTranslation($request->input('lang'));

        if ($res) {
            if ($id > 0) {
                return back()->with('success', __('Category updated'));
            } else {
                return redirect(route('support.admin.ticket.category.index'))->with('success', __('Category created'));
            }
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('support_ticket_category');
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
