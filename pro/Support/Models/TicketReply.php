<?php

namespace Pro\Support\Models;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bc_support_ticket_replies';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
