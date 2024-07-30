<?php


namespace Modules\Media\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Resources\BaseJsonResource;

class MediaResource extends BaseJsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'thumb_size'=>$this->getViewUrl('thumb'),
            'full_size'=>$this->getViewUrl('full'),
            'medium_size'=>$this->getViewUrl('medium'),
            'file_path'=>$this->file_path,
            'file_name'=>$this->file_name,
            'file_type'=>$this->file_type,
            'created_at' => $this->created_at ? display_datetime($this->created_at) : '',
            'file_extension'=>$this->file_extension
        ];
    }
}
