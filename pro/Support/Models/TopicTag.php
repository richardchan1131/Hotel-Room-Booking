<?php

namespace Pro\Support\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pro\Support\Models\Tag;

class TopicTag extends BaseModel
{
    protected $table = 'bc_support_topic_tag_relation';
    protected $fillable = [
        'target_id',
        'tag_id'
    ];

    public static function getModelName()
    {
        return __("Topic Tag");
    }

    public static function searchForMenu($q = false)
    {

    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public static function getAll()
    {
        return self::with('tag')->get();
    }

    public static function addTag($tags_ids, $target_id)
    {
        if (!empty($tags_ids)) {
            foreach ($tags_ids as $tag_id) {
                $find = parent::where('target_id', $target_id)->where('tag_id', $tag_id)->first();
                if (empty($find)) {

                    $a = new self();
                    $a->target_id = $target_id;
                    $a->tag_id = $tag_id;
                    $a->save();
                }
            }
        }
    }
}
