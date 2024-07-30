<?php

namespace Pro\Support\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pro\Support\Models\Topic;

class TopicCat extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;

    protected $table = 'bc_support_topic_cats';
    protected $fillable = [
        'name',
        'content',
        'status',
        'parent_id'
    ];
    protected $slugField = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'support_topic_cat';

    public static function getModelName()
    {
        return __("Support Category");
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'cat_id');
    }

    public function latestTopics($number = 4)
    {
        return $this->topics()->whereStatus('publish')->with('translation')->orderBy('display_order')->orderByDesc('id')->limit($number)->get();
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if (strlen($q)) {

            $query->where('title', 'name', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public function getDetailUrl($product_line = '')
    {
        return route('support.topic.cat', ['slug' => $this->slug]);
    }
}
