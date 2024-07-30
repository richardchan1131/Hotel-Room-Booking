<?php
namespace Modules\User\Models\Wallet;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Booking\Models\Payment;

class Transaction extends BaseModel
{
    use SoftDeletes;

    protected $table = 'credit_transactions';

    protected $casts = [
        'meta' => 'array'
    ];

    public function payment(){
        return $this->belongsTo(Payment::class,'payment_id')->withDefault();
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getStatusNameAttribute(){
        if($this->confirmed){
            return __("Confirmed");
        }
        if(!$this->payment_id || !$this->payment){
            return __("Pending");
        }
        return $this->payment->status_name;
    }
    public function getStatusClassAttribute(){
        if($this->confirmed){
            return 'success';
        }
        if($this->payment_id && $this->payment){
            switch ($this->payment->status){
                case "processing":
                    return 'warning';
                    break;
            }
        }
        return 'warning';
    }

    public function confirm()
    {
        if ($this->author and !$this->status != 'confirmed') {
            $this->author->credit_balance += $this->amount;
            $this->author->save();
        }
        $this->status = 'confirmed';
        $this->save();
    }
}
