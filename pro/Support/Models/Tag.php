<?php

namespace Pro\Support\Models;

use App\BaseModel;

class Tag extends BaseModel
{
    protected $table = 'bc_support_topic_tags';
    protected $fillable = [
        'name',
        'content',
        'slug'
    ];
    protected $slugField = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'support_tag';

    public static function getModelName()
    {
        return __("Topic Tag");
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if ($q) {
            $query->where('name', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public static function saveTagByName($tag_name)
    {
        $ids = [];
        if (!empty($tag_name)) {
            foreach ($tag_name as $name) {
                $find = parent::where('name', trim($name))->first();
                if (empty($find)) {
                    $tag = new self();
                    $tag->name = $name;
                    $tag->save();
                    $ids[] = $tag->id;
                } else {
                    $ids[] = $find->id;
                }
            }
        }
        return $ids;
    }

    public function getDetailUrl($locale = false)
    {
        return route('support.topic.tag', ['slug' => $this->slug]);
    }
}
