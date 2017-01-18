<?php

namespace Nt\Messager;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'target_id',
        'target_type',
        'action',
    ];
}
