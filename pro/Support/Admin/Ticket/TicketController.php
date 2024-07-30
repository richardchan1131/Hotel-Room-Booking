<?php

namespace Pro\Support\Admin\Ticket;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Language\Models\Language;
use Pro\Support\Models\Ticket;
use Pro\Support\Models\TicketCat;

class TicketController extends AdminController
{
    private TicketCat $cat;
    private Ticket $ticket;

    public function __construct(TicketCat $cat, Ticket $ticket)
    {
        $this->setActiveMenu(route('support.admin.ticket.index'));
        $this->cat = $cat;
        $this->ticket = $ticket;
    }

    public function index(Request $request)
    {
        $this->checkPermission('support_ticket_view');
        $dataSupport = $this->ticket->query()->orderBy('id', 'desc');
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
                    'name' => __('Tickets'),
                    'url'  => route('support.admin.ticket.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            "languages"   => Language::getActive(false),
            'page_title'  => __("Ticket Management")
        ];
        return view('Support::admin.ticket.index', $data);
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('support_ticket_update');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == "delete") {
            $this->checkPermission('support_ticket_delete');
            foreach ($ids as $id) {
                $query = $this->ticket->where("id", $id);
                $query->first();
                if (!empty($query)) {
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function trans($id, $locale)
    {
        $row = $this->ticket->find($id);

        if (empty($row)) {
            return redirect()->back()->with("danger", __("Support does not exists"));
        }

        $translated = $this->ticket->query()->where('origin_id', $id)->where('lang', $locale)->first();
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
