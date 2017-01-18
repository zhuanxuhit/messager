<?php

namespace Nt\Messager;

use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    protected $fillable = [
        'user_id',
        'notify_id',
    ];

    public function notify()
    {
        return $this->hasOne(Notify::class);
    }
}
