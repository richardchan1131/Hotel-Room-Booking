<?php


namespace Modules\Flight\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AirportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->name,
            'code'=>$this->code,
            'address'=>$this->address,
            'country'=>$this->country,
            'desc'=>$this->code.' - '.$this->address.', '.$this->country
        ];
    }

}
