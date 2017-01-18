<?php

namespace Nt\Messager;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model {

    // 消息的类型，1: 公告 Announce，2: 提醒 Remind，3：信息 Message
    const ANNOUNCE_TYPE = 1;
    const REMIND_TYPE   = 2;
    const MESSAGE_TYPE  = 3;

    const TARGET_TYPEs = [
        'topic',
        'reply',
        'comment',
    ];

    const ACTION_TYPES = [
        'like',
        'collect',
    ];

    protected $fillable = [
        'content',
        'type',
        'target_id',
        'target_type',
        'action',
        'sender_id',
    ];

    public function userNotifies()
    {
        return $this->hasMany(UserNotify::class);
    }

    public function getNotifyType()
    {
        return $this->type;
    }

}
