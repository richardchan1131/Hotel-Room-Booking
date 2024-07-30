<?php


namespace Modules\User\Models;


use App\BaseModel;

class UserPlan extends BaseModel
{
    protected $table  = 'bravo_user_plan';



    protected $casts = [
        'end_date'=>'datetime',
        'plan_data'=>'array'
    ];

    public function getIsValidAttribute(){
        if(!$this->end_date and $this->status == 1) return true;

        return $this->end_date->timestamp > time() and $this->status == 1;
    }

    public function plan(){
        return $this->belongsTo(Plan::class,'plan_id');
    }
    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

    public function getUsedAttribute(){
        if(!empty($this->user)){
            return $this->user->service()->where('status','publish')->count('id');
        }
        return 0;
    }
}
