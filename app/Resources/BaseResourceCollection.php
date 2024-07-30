<?php


namespace App\Resources;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BaseResourceCollection extends AnonymousResourceCollection
{
    public $needs = [];

    public function toArray($request)
    {
        $this->collection->map(function($item){
           $item->needs = $this->needs;
        });

        return $this->collection->map->toArray($request)->all();
    }
}
