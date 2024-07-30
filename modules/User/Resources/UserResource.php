<?php
namespace Modules\User\Resources;

use App\Resources\BaseJsonResource;

class UserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'avatar_url'=>$this->avatar_url,
            'display_name'=>$this->display_name,
            'billing'=>$this->whenNeed('address',function(){
                return $this->billing_address ?? [];
            }),
            'shipping'=>$this->whenNeed('address',function(){
                return $this->shipping_address ?? [];
            }),
            'text'=>$this->when(request('_type') == 'query',$this->display_name . ' (#' . $this->id . ')'),
            'need_update_pw'=>config('bc.disable_require_password') ? 0 : $this->need_update_pw
        ];
    }
}
