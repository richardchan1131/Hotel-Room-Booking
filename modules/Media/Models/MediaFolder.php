<?php

namespace Modules\Media\Models;

use App\BaseModel;

class MediaFolder extends BaseModel
{
    protected $table = 'media_folders';

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function scopeOfMine($query){
        $query->where('user_id',auth()->id());
    }
}
