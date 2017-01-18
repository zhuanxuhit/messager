<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nt\Messager\Notify;
use Nt\Messager\Services\NotifyService;
use Nt\Messager\Subscription;
use Nt\Messager\UserNotify;

class MessagerAccessibleTest extends TestCase {

    use DatabaseTransactions;

    /**
     * 测试拉取公告
     *
     * @return void
     */
    public function testPullAnnounce()
    {
        //        NotifyService::pullAnnounce(2);
        $user_id = 1;
        Notify::truncate();
        UserNotify::truncate();

        $notifies = factory( Notify::class, 1 )->create( [ 'type' => Notify::ANNOUNCE_TYPE ] );

        $notifies->each( function ( Notify $notify ) use ( $user_id ) {
            $notify->userNotifies()->save( factory( UserNotify::class )->make( [ 'user_id' => $user_id, 'notify_type' => $notify->getNotifyType() ] ) );
        } );
        //        dd($notifies);
        $notify_id = $notifies->first()->getKey();
        $this->seeInDatabase( 'notifies', [ 'id' => $notify_id, 'type' => Notify::ANNOUNCE_TYPE ] );
        $this->seeInDatabase( 'user_notifies', [ 'user_id' => $user_id, 'notify_id' => $notify_id ] );
        // 创建了user_id=1的2个notify
        /** @var Notify $notify */
        Notify::unguard();
        $notify = factory( Notify::class )->make( [ 'type' => Notify::ANNOUNCE_TYPE, 'created_at' => \Carbon\Carbon::now()->nextWeekday() ] );
        $notify->save();
        Notify::reguard();
        NotifyService::pullAnnounce( $user_id );
        $this->seeInDatabase( 'user_notifies', [ 'user_id' => $user_id, 'notify_id' => $notify->getKey() ] );
//        $this->assertEquals( 1, $userNotifies->count() );
    }

    public function testPullRemind()
    {
        $user_id = 1;
        Notify::truncate();
        UserNotify::truncate();
        Subscription::truncate();
        // 1. 创建 remind 2 条
        factory( Notify::class,
                            1 )->create( [ 'type' => Notify::REMIND_TYPE, 'action' => 'like' ] );
        factory( Notify::class,
                            1 )->create( [ 'type' => Notify::REMIND_TYPE, 'action' => 'comment' ] );
        // 2. 订阅remind
        //TODO: fix bug 当我们通过上面直接使用 factory 返回的时候，attribute 属性不对
        $notifies = Notify::all();
        $notify1 = $notifies[0];
        $notify2 = $notifies[1];
        factory( Subscription::class, 1 )->create(
            [
                'user_id'     => $user_id,
                'action'      => $notify1->action,
                'target_id'   => $notify1->target_id,
                'target_type' => $notify1->target_type,
                'created_at'  => \Carbon\Carbon::yesterday(),
            ]
        );

        factory( Subscription::class, 1 )->create(
            [
                'user_id'     => $user_id,
                'action'      => $notify2->action,
                'target_id'   => $notify2->target_id,
                'target_type' => $notify2->target_type,
                'created_at'  => \Carbon\Carbon::yesterday(),
            ]
        );
        // 3. pullRemind
        NotifyService::pullRemind( $user_id );
        $this->seeInDatabase( 'user_notifies', [ 'user_id' => $user_id, 'notify_id' => 1 ] );
        $this->seeInDatabase( 'user_notifies', [ 'user_id' => $user_id, 'notify_id' => 2 ] );
    }

    public function testGetUserNotify(  )
    {
        $user_id = 1;
        Notify::truncate();
        UserNotify::truncate();

        $notifies = factory( Notify::class, 1 )->create( [ 'type' => Notify::ANNOUNCE_TYPE ] );

        $notifies->each( function ( Notify $notify ) use ( $user_id ) {
            $notify->userNotifies()->save( factory( UserNotify::class )->make( [ 'user_id' => $user_id, 'notify_type' => $notify->getNotifyType() ] ) );
        } );

        $userNotifies = NotifyService::getUserNotify($user_id);
        $this->assertEquals(1,$userNotifies->count());
    }
    public function testRead(  )
    {
        $user_id = 1;
        Notify::truncate();
        UserNotify::truncate();
        factory( UserNotify::class,10)->create(['user_id'=>$user_id]);
        $notify_ids = UserNotify::where('user_id',$user_id)->where('is_read',false)->get()->pluck('notify_id');
        $this->assertEquals(10,UserNotify::where('user_id',$user_id)->where('is_read',false)->count());
        $cnt = NotifyService::read($user_id,$notify_ids);
        $this->assertEquals(10,$cnt);
        $this->assertEquals(10,UserNotify::where('user_id',$user_id)->where('is_read',true)->count());
    }
}
