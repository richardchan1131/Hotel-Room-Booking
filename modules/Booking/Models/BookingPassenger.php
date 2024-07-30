<?php


    namespace Modules\Booking\Models;


    use App\BaseModel;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class BookingPassenger extends BaseModel
    {
        use SoftDeletes;
        protected $slugField = false;
        protected $slugFromField = false;
        protected $table ='bravo_booking_passengers';

        protected $fillable = [
            'booking_id',
            'seat_type',
            'email',
            'first_name',
            'last_name',
            'phone',
            'dob',
            'price',
            'id_card'
        ];

        public function booking(){
            return $this->belongsTo(Booking::class,'booking_id');
        }
    }
