<?php

namespace Nt\Messager\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Nt\Messager\Subscription;

trait SubscriptionHandler {

    public static function subscribe( $user_id, $target_id, $target_type, $reason )
    {
        $reasonAction = config('messager.reasonAction');
        $actions       = $reasonAction[ $reason ];
        $actions       = new Collection( $actions );
        $subscriptions = $actions->map( function ( $action ) use ( $user_id, $target_id, $target_type ) {
            return [
                'action'      => $action,
                'user_id'     => $user_id,
                'target_id'   => $target_id,
                'target_type' => $target_type,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        } )->all();
        DB::table( 'subscriptions' )->insert( $subscriptions );
        return true;
    }

    public static function cancelSubscription($user_id, $target_id ,$target_type)
    {
        return Subscription::where('user_id',$user_id)
            ->where('target_id',$target_id)
            ->where('target_type',$target_type)
            ->delete();
    }
}