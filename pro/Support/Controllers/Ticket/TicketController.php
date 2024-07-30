<?php

namespace Pro\Support\Controllers\Ticket;

use App\Helpers\ReCaptchaEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\FrontendController;
use Pro\Support\Emails\TicketHasNewReplyEmail;
use Pro\Support\Models\Ticket;
use Pro\Support\Models\TicketCat;
use Pro\Support\Models\TicketReply;
use Pro\Support\Models\UserNote;

class TicketController extends FrontendController
{

    private Ticket $ticket;
    private TicketCat $cat;
    private TicketReply $reply;

    public function __construct(Ticket $ticket, TicketCat $cat, TicketReply $reply)
    {
        parent::__construct();
        $this->ticket = $ticket;
        $this->cat = $cat;
        $this->reply = $reply;
    }

    public function index()
    {
        $params = [
            's'     => \request('s'),
            'catId' => \request('catId')
        ];
        $isAgent = \auth()->user()->hasPermission('support_ticket_reply');
        $isAdmin = \auth()->user()->hasPermission('support_ticket_manage');
        $support_ticket_view_type = setting_item('support_ticket_view_type');
        if ($isAgent || $isAdmin) {
            if ($support_ticket_view_type !== 'all' || !$isAdmin) {
                $params['agentId'] = auth()->id();
            }
        } else {
            $params['customerId'] = auth()->id();
        }
        $query = $this->ticket->search($params);
        $page_title = __('All Tickets');

        if (!empty($params['catId'])) {
            $cat = $this->cat->find($params['catId']);
            if ($cat) {
                $cat_trans = $cat->translate();
                $page_title = $cat_trans->name;
            }
        }

        if (request('s')) {
            $page_title = __("Search result for: :name", ['name' => request('s')]);
        }
        $query->with(['cat', 'last_reply']);
        if ($isAgent) {
            $query->orderByRaw("CASE WHEN status = 'open' THEN 1 ELSE 2 END ASC");
            $query->orderByRaw("CASE WHEN customer_id = last_reply_by THEN 1 ELSE 2 END ASC");
            $query->orderBy('last_reply_at');
        } else {
            $query->orderByDesc('id');
        }
        $data = [
            'page_title'  => $page_title,
            'rows'        => $query->paginate(20),
            'is_agent'    => $isAgent,
            'breadcrumbs' => [
                [
                    'name' => __('My Tickets'),
                    'url'  => route('support.ticket.index')
                ],
            ]
        ];

        return view('Support::frontend.ticket.index', $data);
    }

    public function detail($id)
    {
        $query = $this->ticket->whereId($id);
        $isAgent = \auth()->user()->hasPermission('support_ticket_reply');
        $isAdmin = \auth()->user()->hasPermission('support_ticket_manage');
        if (!$isAdmin) {
            if ($isAgent) {
                $query->whereAgentId(\auth()->id());
            } else {
                $query->whereCustomerId(\auth()->id());
            }
        }
        $ticket = $query->first();

        if (!$ticket) abort(404);

        $data = [
            'page_title'  => $ticket->title,
            'row'         => $ticket,
            'breadcrumbs' => [
                [
                    'name' => __('My Tickets'),
                    'url'  => route('support.ticket.index')
                ],
                [
                    'name' => $ticket->title,
                ],
            ],
            'is_agent'    => $isAgent
        ];

        return view('Support::frontend.ticket.detail', $data);
    }

    public function create()
    {
        $this->checkPermission('support_ticket_create');
        $data = [
            'page_title'  => __("Create a ticket"),
            'categories'  => $this->cat::query()->whereStatus('publish')->get()->toTree(),
            'breadcrumbs' => [
                [
                    'name' => __('My Tickets'),
                    'url'  => route('support.ticket.index')
                ],
                [
                    'name' => __('Create a ticket'),
                ]
            ]
        ];

        return view('Support::frontend.ticket.create', $data);
    }


    public function store(Request $request)
    {

        $this->checkPermission('support_ticket_create');
        $this->validate($request, [
            'title'   => 'required|max:255',
            'content' => 'required|max:6500',
            'cat_id'  => 'required',
        ]);

        if (ReCaptchaEngine::isEnable()) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                return redirect()->back()->withInput()->with('danger', __("Please verify the captcha"));
            }
        }

        $row = $this->ticket;
        $row->customer_id = Auth::id();
        $row->last_reply_by = Auth::id();
        $row->last_reply_at = date('Y-m-d H:i:s');

        $row->fillByAttr([
            'title',
            'content',
            'cat_id',
        ], $request->input());
        $row->content = strip_tags($row->content);
        $row->save();

        return redirect(route('support.ticket.index'))->with('success', __('Ticket created'));
    }


    public function reply_store(Request $request, $id)
    {

        $this->validate($request, [
            'content' => 'required|max:6500'
        ]);

        if (ReCaptchaEngine::isEnable()) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                return redirect()->back()->withInput()->with('danger', __("Please verify the captcha"));
            }
        }
        $query = $this->ticket->whereId($id);
        $isAgent = \auth()->user()->hasPermission('support_ticket_reply');
        $isAdmin = \auth()->user()->hasPermission('support_ticket_manage');
        if (!$isAdmin) {
            if ($isAgent) {
                $query->whereAgentId(\auth()->id());
            } else {
                $query->whereCustomerId(\auth()->id());
            }
        }
        $ticket = $query->first();

        if (empty($ticket)) {
            abort(403);
        }

        if ($ticket->status == 'closed') {
            return redirect()->back()->with("danger", "Ticket closed");
        }

        $reply = new $this->reply();
        $reply->content = clean($request->input('content'));
        $reply->user_id = Auth::id();
        $reply->ticket_id = $id;

        if ($reply->save()) {

            $ticket->last_reply_by = Auth::id();
            $ticket->last_reply_at = date('Y-m-d H:i:s');
            $ticket->save();

            if ($ticket->customer_id != \auth()->id()) {
                Mail::to($ticket->customer)->queue(new TicketHasNewReplyEmail($ticket, $reply));
            } else {
                Mail::to($ticket->agent)->queue(new TicketHasNewReplyEmail($ticket, $reply));
            }

            return redirect()->back()->with('success', __("Reply created"));
        }

        return redirect()->back()->with('danger', __("Can not add reply"));

    }

    public function action(Request $request, $id)
    {
        $query = $this->ticket->whereId($id);

        $isAgent = \auth()->user()->hasPermission('support_ticket_reply');
        $isAdmin = \auth()->user()->hasPermission('support_ticket_manage');
        if (!$isAgent or !$isAdmin) abort(403);

        $ticket = $query->first();

        if (empty($ticket)) {
            abort(403);
        }

        $this->validate($request, [
            'action' => 'required'
        ]);

        switch ($request->input('action')) {
            case "status":
                $status = $request->input('status');
                if ($ticket->status != $status) {
                    $ticket->status = $status;

                    if ($status == 'closed') {
                        $ticket->closed_at = date('Y-m-d H:i:s');
                        $ticket->closed_by = auth()->id();
                    }

                    $ticket->save();
                }
                break;
            case "user_note":
                $note_content = $request->input('note_content');
                if ($note_content) {
                    $note = new UserNote();
                    $note->user_id = $ticket->customer_id;
                    $note->content = $note_content;
                    $note->save();
                }
                return redirect()->back()->with('success', 'Note added');
                break;
        }
        return redirect()->back()->with('success', 'Saved');
    }
}
