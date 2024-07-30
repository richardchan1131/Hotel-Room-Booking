<?php

namespace Pro\Support\Models;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pro\Support\Models\SupportUser;
use Pro\Support\Models\TicketCat;
use Pro\Support\Models\TicketReply;

class Ticket extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bc_support_tickets';

    function cat()
    {
        return $this->belongsTo(TicketCat::class);
    }

    function getEditUrl()
    {
        return route('support.ticket.detail', ['id' => $this->id]);
    }

    public function getDetailUrl()
    {
        return route('support.ticket.detail', ['id' => $this->id]);
    }

    function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    function customer()
    {
        return $this->belongsTo(SupportUser::class, 'customer_id');
    }


    public function search($filters = [])
    {
        $query = self::query();
        if (!empty($filters['s'])) {
            $query->where('title', 'like', '%' . $filters['s'] . '%');
        }
        if (!empty($filters['catId'])) {
            $query->whereCatId($filters['catId']);
        }
        if (!empty($filters['customerId'])) {
            $query->whereCustomerId($filters['customerId']);
        }
        if (!empty($filters['agentId'])) {
            $query->whereAgentId($filters['agentId']);
        }
        return $query;
    }


    public function getStatusBadgeClassAttribute()
    {

        switch (strtolower($this->status)) {
            case "solved":
            case "closed":
                return "success";
                break;
            default:
                return "warning";
                break;
        }
    }

    public function getStatusTextAttribute()
    {
        switch (strtolower($this->status)) {

            case "solved":
            case "closed":
                return __("Closed");
                break;
            default:
                return __("Open");
                break;
        }
    }


    public function last_reply()
    {
        return $this->belongsTo(User::class, 'last_reply_by');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }
}
