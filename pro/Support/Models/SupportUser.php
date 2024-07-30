<?php

namespace Pro\Support\Models;

use App\User;
use Pro\Support\Models\UserNote;

class SupportUser extends User
{

    protected $table = 'users';

    public function notes()
    {
        return $this->hasMany(UserNote::class, 'user_id');
    }
}
