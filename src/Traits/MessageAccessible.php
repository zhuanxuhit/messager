<?php

namespace Nt\Messager\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Nt\Messager\Notify;
use Nt\Messager\Subscription;
use Nt\Messager\UserNotify;

trait MessageAccessible {

    /**
     * 拉取公告信息
     * @param $user_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|[]UserNotify
     */
    public static function pullAnnounce( $user_id )
    {
        // TODO:此处如果用户信息（UserNotify）非常多的话，会有问题
        // user_notifies.notify_id = notifies.id
        // notifies.type = 1
        /** @var \Illuminate\Database\Eloquent\Collection $userNotifies */
        $userNotifies = UserNotify::where( 'user_id', $user_id )
            ->where('notify_type',Notify::ANNOUNCE_TYPE)
            ->get();

        $notifyIds = $userNotifies->pluck('notify_id')->all();

        $lastAnnounce = Notify::where( 'type', Notify::ANNOUNCE_TYPE )
            ->whereIn( 'id', $notifyIds )
            ->orderBy( 'created_at', 'desc' )
            ->first();

        if ( !$lastAnnounce ) {
            $lastTime = 0;
        } else {
            $lastTime = $lastAnnounce->created_at;
        }

        /** @var \Illuminate\Database\Eloquent\Collection $notifies */
        $notifies = Notify::where( 'type', Notify::ANNOUNCE_TYPE )
            ->where( 'created_at', '>', $lastTime )
            ->get();

        // 批量将这些notifies插入到UserNotify中
        $userNotifies = $notifies->map( function ( Notify $notify ) use ( $user_id ) {
            return [
                'user_id'   => $user_id,
                'notify_id' => $notify->getKey(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        } )->all();
//        dd($userNotifies);
        if ( !empty( $userNotifies ) ) {
            DB::table( 'user_notifies' )->insert( $userNotifies );
        }
        return $userNotifies;
    }

    public static function pullRemind( $user_id )
    {
        $subscriptions = Subscription::where('user_id',$user_id)->get();

    }
}