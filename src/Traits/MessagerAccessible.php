<?php

namespace Nt\Messager\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Nt\Messager\Notify;
use Nt\Messager\Subscription;
use Nt\Messager\UserNotify;

trait MessagerAccessible {

    /**
     * @param $user_id
     *
     * @return mixed
     */
    public static function getUserNotify( $user_id )
    {
        return UserNotify::where('user_id',$user_id)
            ->orderBy('id','desc')
            ->with('notify')
            ->get();
    }

    public static function read( $user_id, $notify_ids )
    {
        return UserNotify::where('user_id',$user_id)
            ->whereIn('notify_id',$notify_ids)
            ->update(['is_read'=>true]);
    }

    /**
     * 拉取公告信息
     * @param $user_id
     *
     * @return true
     */
    public static function pullAnnounce( $user_id )
    {
        $maxNotifyId = UserNotify::where( 'user_id', $user_id )
            ->where('notify_type',Notify::ANNOUNCE_TYPE)
            ->max('notify_id');

        $notifies = Notify::where( 'type', Notify::ANNOUNCE_TYPE )
            ->where( 'id', '>', $maxNotifyId )
            ->get();

        // 批量将这些notifies插入到UserNotify中
        return static::createUserNotify($user_id,$notifies);
    }

    /**
     * @param            $user_id
     * @param $notifies
     *
     * @return true
     */
    protected static function createUserNotify( $user_id, $notifies )
    {

        $userNotifies = $notifies->map( function ( Notify $notify ) use ( $user_id ) {
            return [
                'user_id'   => $user_id,
                'notify_id' => $notify->getKey(),
                'notify_type' => $notify->getNotifyType(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        } )->all();
        //        dd($userNotifies);
        if ( !empty( $userNotifies ) ) {
            DB::table( 'user_notifies' )->insert( $userNotifies );
//            return UserNotify::where( 'user_id', $user_id )
//                ->where('notify_type',Notify::ANNOUNCE_TYPE)
//                ->where('notify_id','>',$maxNotifyId)
//                ->with('notify')->get();
        }
        return true;
//        return (new UserNotify)->newCollection();
    }

    /**
     * @param $user_id
     *
     * @return true
     */
    public static function pullRemind( $user_id )
    {
        $subscriptions = Subscription::where('user_id',$user_id)->get();

        // 从中找出自己关注的
        // where target_id, target_type, action
        $notifies =  $subscriptions->flatMap(function(Subscription $subscription){
             return Notify::where('target_id',$subscription->target_id)
                 ->where('target_type',$subscription->target_type)
                 ->where('action',$subscription->action)
                 ->where('created_at','>',$subscription->created_at)
                 ->get();
        });

        return static::createUserNotify($user_id,$notifies);
    }
}