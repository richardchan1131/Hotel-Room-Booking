<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/16/2019
 * Time: 2:05 PM
 */

namespace Pro\Support\Models;

use App\BaseModel;

class TopicTranslation extends BaseModel
{
    protected $table = 'bc_support_topic_translations';
    protected $fillable = ['title', 'content'];
    protected $seo_type = 'support_topic_trans';
    protected $cleanFields = [
        'content'
    ];
}
