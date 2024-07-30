<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/16/2019
 * Time: 2:05 PM
 */

namespace Pro\Support\Models;

use App\BaseModel;

class TopicCatTranslation extends BaseModel
{
    protected $table = 'bc_support_topic_cat_translations';
    protected $fillable = ['name', 'content'];
    protected $seo_type = 'support_topic_cat_tran';
    protected $cleanFields = [
        'content'
    ];
}
