<?php


namespace Modules\User\Models;


use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTranslation extends BaseModel
{

    use SoftDeletes;

    protected $table = 'bravo_plan_trans';

    protected $fillable = [
        'title',
        'content',
    ];
}
