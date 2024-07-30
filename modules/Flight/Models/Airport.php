<?php


    namespace Modules\Flight\Models;


    use App\BaseModel;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Flight\Factories\AirportFactory;
    use Modules\Location\Models\Location;

    class Airport extends BaseModel
    {
        use HasFactory;

        protected $table = 'bravo_airport';

        protected $fillable=[
            'name',
            'code',
            'location_id',
            'description',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
        ];

        protected static function newFactory()
        {
            return AirportFactory::new();
        }
        public function location(){
            return $this->belongsTo(Location::class,'location_id');
        }
    }
