<?php
namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Modules\Core\Models\Terms;
use Modules\Location\Models\Location;

class Service extends BaseModel
{
    use SoftDeletes;
    public    $type          = 'service';
    protected $table         = 'bravo_services';
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $fillable      = [
        'title',
        'location_id',
        'category_id',
        'address',
        'map_lat',
        'map_lng',
        'is_featured',
        'star_rate',
        'price',
        'sale_price',
        'min_people',
        'max_people',
        'max_guests',
        'review_score',
        'min_day_before_booking',
        'min_day_stays',
        'locale',
        'object_id',
        'object_model',
        'status'
    ];

    public static function cloneService($model, $event)
    {
        try {
            if (!empty($model->type) and $model->type != 'service') {
                $service = self::where('object_model', $model->type)->where('object_id', $model->id)->first();
                if (empty($service)) {
                    $service = new Service();
                }
                if (is_default_lang()) {
                    $service->fill($model->attributes);
                    $service->object_id = $model->id;
                    $service->object_model = $model->type;
                    $service->author_id = $model->author_id;
                    $service->save();
                } else {
                    $getRecordRoot = $model->getRecordRoot;
                    if (!empty($getRecordRoot)) {
                        $service = self::where('object_model', $getRecordRoot->type)->where('object_id', $getRecordRoot->id)->first();
                        if (empty($service)) {
                            $service = new Service();
                            $service->fill($getRecordRoot->attributes);
                            $service->object_id = $getRecordRoot->id;
                            $service->object_model = $getRecordRoot->type;
                            $service->author_id = $getRecordRoot->author_id;
                            $service->save();
                        }
                        $serviceTranslation = new ServiceTranslation($model->attributes);
                        $service->Translations()->save($serviceTranslation);
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }

    public static function deleteService($model)
    {
        try {
            if (!empty($model->type) and $model->type != 'service') {
                $service = self::where('object_model', $model->type)->where('object_id', $model->id)->first();
                if (!empty($service)) {
                    $a = $service->delete();
                }
            }
        } catch (\Exception $e) {
        }
    }

    public static function restoreService($model)
    {
        try {
            if (!empty($model->type) and $model->type != 'service') {
                $service = self::withTrashed()->where('object_model', $model->type)->where('object_id', $model->id)->first();
                if (!empty($service)) {
                    $service->restore();
                }
            }
        } catch (\Exception $e) {
        }
    }

    public function search($request)
    {
        $model_service = parent::query()->select("bravo_services.*");
        $model_service->where("bravo_services.status", "publish");
        if (!empty($location_id = $request['location_id'] ?? "" )) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $model_service->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_services.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($price_range = $request['price_range'] ?? "")) {
            $pri_from = explode(";", $price_range)[0];
            $pri_to = explode(";", $price_range)[1];
            $raw_sql_min_max = "( (IFNULL(bravo_services.sale_price,0) > 0 and bravo_services.sale_price >= ? ) OR (IFNULL(bravo_services.sale_price,0) <= 0 and bravo_services.price >= ? ) )
                            AND ( (IFNULL(bravo_services.sale_price,0) > 0 and bravo_services.sale_price <= ? ) OR (IFNULL(bravo_services.sale_price,0) <= 0 and bravo_services.price <= ? ) )";
            $model_service->WhereRaw($raw_sql_min_max,[$pri_from,$pri_from,$pri_to,$pri_to]);
        }
        $review_scores = $request['review_score'] ?? [];
        if (is_array($review_scores) && !empty($review_scores)) {
            $where_review_score = [];
            $params = [];
            foreach ($review_scores as $number){
                $where_review_score[] = " ( bravo_services.review_score >= ? AND bravo_services.review_score <= ? ) ";
                $params[] = $number;
                $params[] = $number.'.9';
            }
            $sql_where_review_score = " ( " . implode("OR", $where_review_score) . " )  ";
            $model_service->WhereRaw($sql_where_review_score,$params);
        }
        if (!empty($service_name = $request['service_name'] ?? [])) {
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $model_service->leftJoin('bravo_service_translations', function ($join) {
                    $join->on('bravo_services.id', '=', 'bravo_service_translations.origin_id');
                });
                $model_service->where('bravo_service_translations.title', 'LIKE', '%' . $service_name . '%');

            }else{
                $model_service->where('bravo_services.title', 'LIKE', '%' . $service_name . '%');
            }
        }
        $orderby = $request['orderby'] ?? "";
        switch ($orderby){
            case "price_low_high":
                $raw_sql = "CASE WHEN IFNULL( bravo_services.sale_price, 0 ) > 0 THEN bravo_services.sale_price ELSE bravo_services.price END AS tmp_min_price";
                $model_service->selectRaw($raw_sql);
                $model_service->orderBy("tmp_min_price", "asc");
                break;
            case "price_high_low":
                $raw_sql = "CASE WHEN IFNULL( bravo_services.sale_price, 0 ) > 0 THEN bravo_services.sale_price ELSE bravo_services.price END AS tmp_min_price";
                $model_service->selectRaw($raw_sql);
                $model_service->orderBy("tmp_min_price", "desc");
                break;
            case "rate_high_low":
                $model_service->orderBy("review_score", "desc");
                break;
            default:
                if(!empty($request['order']) and !empty($request['order_by'])){
                    $model_service->orderBy("bravo_tours.".$request['order'], $request['order_by']);
                }else{
                    $model_service->orderBy("is_featured", "desc");
                    $model_service->orderBy("id", "desc");
                }
        }
        $model_service->groupBy("bravo_services.id");
        return $model_service->with([
            'translation'
        ]);
    }
    public function dataForApi($forSingle = false){
        $service = $this->service;
        $data = $service->dataForApi();
        return $data;
    }

    public function service()
    {
        $all = get_bookable_services();
        if ($this->object_model and !empty($all[$this->object_model])) {
            return $this->hasOne($all[$this->object_model], 'id', 'object_id');
        }
        return null;
    }
}

