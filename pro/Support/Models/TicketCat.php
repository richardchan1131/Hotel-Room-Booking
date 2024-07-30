<?php

namespace Pro\Support\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Pro\Support\Models\TicketCatTranslation;

class TicketCat extends BaseModel
{
    use NodeTrait;
    use SoftDeletes;

    protected $translation_class = TicketCatTranslation::class;

    protected $table = 'bc_support_ticket_categories';

    protected $fillable = [
        'name',
        'content',
        'status',
        'parent_id'
    ];
    protected $slugField = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'support_ticket_cat';

    public function getDetailUrl()
    {
        return route('support.ticket.index', ['catId' => $this->id]);
    }
}
