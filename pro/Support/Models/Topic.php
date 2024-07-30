<?php

namespace Pro\Support\Models;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Pro\Support\Models\Tag;
use Pro\Support\Models\TopicCat;
use Pro\Support\Models\TopicTag;
use Pro\Support\Models\TopicTranslation;

class Topic extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bc_support_topics';
    protected $fillable = [
        'title',
        'content',
        'status',
        'slug',
        'cat_id',
        'image_id'
    ];
    protected $slugField = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'support_topic';
    protected $translation_class = TopicTranslation::class;

    public function getDetailUrlAttribute()
    {
        return route('support.topic.detail', ['slug' => $this->slug]);
    }

    public function cat()
    {
        return $this->belongsTo(TopicCat::class);
    }

    public static function getAll()
    {
        return self::with('cat')->get();
    }

    public function getDetailUrl($product_line = '')
    {
        if (!$this->slug) return '';
        return route('support.topic.detail', ['slug' => $this->slug]);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, TopicTag::class, 'target_id', 'tag_id');
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if (strlen($q)) {

            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public function saveTag($tags_name, $tag_ids)
    {

        if (empty($tag_ids))
            $tag_ids = [];
        $tag_ids = array_merge(Tag::saveTagByName($tags_name), $tag_ids);
        $tag_ids = array_filter(array_unique($tag_ids));
        // Delete unused
        TopicTag::whereNotIn('tag_id', $tag_ids)->where('target_id', $this->id)->delete();
        //Add
        TopicTag::addTag($tag_ids, $this->id);
    }

    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = setting_item_with_lang("support.topic_page_list_seo_title", false, null) ?? setting_item_with_lang("support.topic_page_list_title", false, null) ?? __("Support");
        $meta['seo_desc'] = setting_item_with_lang("support.topic_page_list_seo_desc");
        $meta['seo_image'] = setting_item("support.topic_page_list_seo_image", null) ?? setting_item("support.topic_page_list_banner", null);
        $meta['seo_share'] = setting_item_with_lang("support.topic_page_list_seo_share");
        $meta['full_url'] = url(config('support.topic.support.topic_route_prefix'));
        return $meta;
    }

    public function getEditUrl()
    {
        return route('support.admin.topic.edit', ['id' => $this->id]);
    }

    public function related()
    {
        return $this->hasMany(Topic::class, 'cat_id', 'cat_id')->whereNot('id', $this->id);
    }

    public function search($filters = [])
    {
        $query = self::query()->select($this->qualifyColumn('*'));
        if (!empty($filters['s'])) {
            $query->where('title', 'like', '%' . $filters['s'] . '%');
        }
        if (!empty($filters['catId'])) {
            $query->whereCatId($filters['catId']);
        }
        if (!empty($filters['tagId'])) {
            $query->join('bc_support_topic_tag_relation', function ($join) use ($filters) {
                $join->on('bc_support_topic_tag_relation.target_id', $this->qualifyColumn('id'));
                $join->where('bc_support_topic_tag_relation.tag_id', $filters['tagId']);
                return $join;
            });
            $query->groupBy($this->qualifyColumn('id'));
        }
        return $query;
    }
}
