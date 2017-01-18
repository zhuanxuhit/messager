<?php

namespace Nt\Messager;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    static $reasonAction = [
        'create_topic' => ['like','comment'],
        'like_reply' => ['comment'],
    ];

    protected $fillable = [
        'user_id',
        'target_id',
        'target_type',
        'action',
    ];
}
