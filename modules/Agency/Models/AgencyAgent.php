<?php
namespace Modules\Agency\Models;

use App\BaseModel;

class AgencyAgent extends BaseModel
{
    protected $table = 'bc_agencies_agent';
    protected $fillable = [
        'agencies_id',
        'agent_id',
    ];
    public $timestamps = true;
}
