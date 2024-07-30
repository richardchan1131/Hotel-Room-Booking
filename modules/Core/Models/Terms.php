<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Boat\Models\Boat;
use Modules\Boat\Models\BoatTerm;
use Modules\Car\Models\Car;
use Modules\Car\Models\CarTerm;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventTerm;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightTerm;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelTerm;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceTerm;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourTerm;

class Terms extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bravo_terms';
    protected $fillable = [
        'name',
        'content',
        'image_id',
        'icon',
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    /**
     * @param $term_IDs array or number
     * @return mixed
     */
    static public function getTermsById($term_IDs){
        $listTerms = [];
        if(empty($term_IDs)) return $listTerms;
        $terms = parent::query()->with(['translation','attribute'])->find($term_IDs);
        if(!empty($terms)){
            foreach ($terms as $term){
                if(!empty($attr = $term->attribute)){
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['parent'] = $attr;
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['child'] = [];
                    $listTerms[$term->attr_id]['child'][] = $term;
                }
            }
        }
        return $listTerms;
    }

    public function attribute()
    {
        return $this->hasOne("Modules\Core\Models\Attributes", "id" , "attr_id");
    }


    public static function getForSelect2Query($service,$q=false)
    {
        $query =  static::query()->select('bravo_terms.id', DB::raw('CONCAT(at.name,": ",bravo_terms.name) as text'))
        ->join('bravo_attrs as at','at.id','=','bravo_terms.attr_id')
        // ->where("bravo_terms.status","publish")
        // ->where("at.status","publish")
        ->where("at.service",$service)
        ->whereRaw("at.deleted_at is null");

        if ($query) {
            $query->where('bravo_terms.name', 'like', '%' . $q . '%');
        }
        return $query;
    }

    static public function getTermsByIdForAPI($term_IDs){
        $listTerms = null;
        if(empty($term_IDs)) return $listTerms;
        $terms = parent::query()->with(['translation','attribute'])->find($term_IDs);
        if(!empty($terms)){
            foreach ($terms as $term){
                $attr = $term->attribute;
                if(!$attr) continue;

                $attrTranslation = $attr->translate();
                $dataAttr = array(
                    'id'=>$attr->id,
                    'title'=>$attrTranslation->name,
                    'slug'=>$attr->slug,
                    'service'=>$attr->service,
                    'display_type'=>$attr->display_type,
                    'hide_in_single'=>$attr->hide_in_single,
                );
                if(!empty($dataAttr) and empty($dataAttr['hide_in_single'])){
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['parent'] = $dataAttr;
                    if(empty($listTerms[$term->attr_id]['child'])) $listTerms[$term->attr_id]['child'] = [];
                    $termTranslation = $term->translate();
                    $dataAttr = array(
                        'id'=>$term->id,
                        'title'=>$termTranslation->name,
                        'content'=>$term->content,
                        'image_id'=>get_file_url($term->image_id,'full'),
                        'icon'=>$term->icon,
                        'attr_id'=>$term->attr_id,
                        'slug'=>$term->slug,
                    );
                    $listTerms[$term->attr_id]['child'][] = $dataAttr;
                }
            }
        }
        return $listTerms;
    }

    public function dataForApi(){
        $translation = $this->translate();
        return [
            'id'=>$this->id,
            'name'=>$translation->name,
            'slug'=>$this->slug,
        ];
    }

    public function space(){
        return $this->belongsToMany(Space::class,SpaceTerm::getTableName(),'term_id','target_id');
    }
    public function tour(){
        return $this->belongsToMany(Tour::class,TourTerm::getTableName(),'term_id','tour_id');
    }
    public function hotel(){
        return $this->belongsToMany(Hotel::class,HotelTerm::getTableName(),'term_id','target_id');
    }
    public function car(){
        return $this->belongsToMany(Car::class,CarTerm::getTableName(),'term_id','target_id');
    }
    public function event(){
        return $this->belongsToMany(Event::class,EventTerm::getTableName(),'term_id','target_id');
    }
    public function flight(){
        return $this->belongsToMany(Flight::class,FlightTerm::getTableName(),'term_id','target_id');
    }
    public function boat(){
        return $this->belongsToMany(Boat::class,BoatTerm::getTableName(),'term_id','target_id');
    }
}
