<?php


namespace Modules\Core\Helpers;


use Illuminate\Support\Facades\Cache;

class SitemapHelper
{
    protected $all_pages = [];
    protected $active_pages = [];

    public function add($id,$callable,$priority = 10){
        $this->all_pages[] = [$id,$callable,$priority];
    }

    public function all(){
        return $all = $this->loadActives();
    }

    public function path($path_id = false){
        $all = $this->loadActives();
        if(!array_key_exists($path_id,$all)) return [];

        $item =  $all[$path_id];

        return Cache::remember('sitemap_'.$path_id, 5 * DAY_IN_SECONDS, function () use ($item) {
            return call_user_func($item['callable']);
        });
    }

    public function clear($path_id){
        Cache::forget('sitemap_'.$path_id);
    }

    protected function loadActives(){
        if(!empty($this->active_pages)) return $this->active_pages;

        foreach ($this->all_pages as $data){
            list($id,$callable,$priority) = $data;

            if(!is_callable($callable)){
                continue;
            };

            if(!array_key_exists($id,$this->active_pages)){
                $this->active_pages[$id] = [
                    'callable'=>$callable,
                    'priority'=>$priority
                ];
            }else{
                if(version_compare($priority,$this->active_pages[$id]['priority'],'>')){
                    $this->active_pages[$id] = [
                        'callable'=>$callable,
                        'priority'=>$priority
                    ];
                }
            }

        }
        return $this->active_pages;
    }
}
