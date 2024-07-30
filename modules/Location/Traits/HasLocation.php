<?php

namespace Modules\Location\Traits;

use Modules\Location\Models\Location;

trait HasLocation
{

    /**
     * Get Location
     */
    public function location()
    {
        return $this->belongsTo(Location::class, "location_id")->with(['translation']);
    }

    public function locationBreadcrumbs(){
        $res = [];
        if($this->location){
            $parents = $this->location->ancestorsOf($this->location);
            foreach ($parents as $parent){
                $translation = $parent->translate();
                $res[] = [
                    'name'  => $translation->name,
                    'url'  => route('location.detail',['slug'=>$parent->slug]),
                ];
            }
            $translation = $this->location->translate();
            $res[] = [
                'name'  => $translation->name,
                'url'  => route('location.detail',['slug'=>$this->location->slug]),
            ];
        }
        return $res;
    }
}
