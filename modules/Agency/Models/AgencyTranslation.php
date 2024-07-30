<?php
namespace Modules\Agency\Models;

use App\BaseModel;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Models\Property;
use Modules\Review\Models\Review;

class AgencyTranslation extends Agency
{
    /**
     * limit agencies
     */
    const LIMIT_AGENCY = 6;

    use SoftDeletes;
    protected $table = 'bc_agencies_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $slugField = false;
    protected $seo_type = 'agency_translation';
}
