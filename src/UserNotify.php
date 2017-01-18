<?php

namespace Nt\Messager;

use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    protected $fillable = [
        'user_id',
        'notify_id',
        'notify_type',
    ];

//    public function notify()
//    {
//        return $this->hasOne(Notify::class,'notify_id','id');
//    }
    public function notify()
    {
        return $this->belongsTo(Notify::class);
    }
}
