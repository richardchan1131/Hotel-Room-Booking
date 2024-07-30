<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/16/2019
 * Time: 2:05 PM
 */

namespace Pro\Support\Models;

use App\BaseModel;

class TicketCatTranslation extends BaseModel
{
    protected $table = 'bc_support_ticket_category_translation';
    protected $fillable = ['name', 'content'];
    protected $seo_type = 'support_ticket_cat_tran';
    protected $cleanFields = [
        'content'
    ];
}
