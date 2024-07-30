<?php

namespace Modules\Booking\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearchFilter
{
    public function filterAttrs($query,$attrs,$termTable = '',$targetColName = 'target_id'){

        $mainTable = $this->table;
        $index = 0;
        foreach ($attrs as $terms){
            $index ++;
            if(!empty($terms)){
                $query->join($termTable.' as attr_'.$index, function($join) use ($index,$mainTable,$targetColName){
                    $join->on('attr_'.$index.'.'.$targetColName, $mainTable.".id");
                });
                $query->join('bravo_terms as term_'.$index, function($join2) use ($index,$terms){
                    $join2->on('term_'.$index.'.id', 'attr_'.$index.".term_id");
                    $join2->whereIn('term_'.$index.'.slug', $terms);
                });
            }
        }
        return $query;
    }

    public function filterReviewScore(Builder $query,$scores){

        $query->where(function($q) use ($scores){
            foreach ($scores as $score){
                $q->orWhereBetween($this->qualifyColumn('review_score'),[$score,$score.'.9']);
            }
        });

        return $query;
    }

    public function filterLatLng(Builder $query,$lat,$lng){

        $colLat = $this->qualifyColumn('map_lat');
        $colLng = $this->qualifyColumn('map_lng');
        //			3959 - Miles(dặm), 6371 - Kilometers
        $distance  = setting_item($this->type.'_location_radius_value',0);
        if(!empty($distance) and setting_item($this->type.'_location_search_style')=='autocompletePlace'){
            $distanceType = setting_item($this->type.'_location_radius_type',3959);
            if(empty($distanceType)){
                $distanceType = 3959;
            }
            $string = '( ? * acos(
                            cos( radians(?) ) * cos( radians( map_lat ) ) * cos( radians( map_lng ) - radians(?) )
                            + sin( radians(?) ) * sin( radians(map_lat) )
                             )
                     ) <= ?';
            $query->whereRaw($string,[$distanceType,$lat,$lng,$lat,$distance]);
        }

//            ORDER BY (POW((lon-$lon),2) + POW((lat-$lat),2))";
        $query->orderByRaw("POW(({$colLat} - ?),2) + POW(( {$colLng} - ?),2)",[$lng,$lat]);

        return $query;
    }
}
