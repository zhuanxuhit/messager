<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nt\Messager\Services\NotifyService;
use Nt\Messager\Subscription;

class SubscriptionHandlerTest extends TestCase {

    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSubscribe()
    {
        $user_id     = 1;
        $target_id   = 1;
        Subscription::truncate();
        $target_type = 'topic';
        NotifyService::subscribe( $user_id, $target_id, $target_type, 'create_topic' );
        $this->seeInDatabase( 'subscriptions', [
            'user_id'     => $user_id,
            'target_id'   => $target_id,
            'target_type' => $target_type,
            'action' => 'like',
        ] );
        $this->seeInDatabase( 'subscriptions', [
            'user_id'     => $user_id,
            'target_id'   => $target_id,
            'target_type' => $target_type,
            'action' => 'comment',
        ] );
    }

    public function testCancelSubscription(  )
    {
        $user_id     = 1;
        $target_id   = 1;
        Subscription::truncate();
        $target_type = 'topic';
        NotifyService::subscribe( $user_id, $target_id, $target_type, 'create_topic' );

        $cnt = NotifyService::cancelSubscription($user_id,$target_id,$target_type);
        $this->assertEquals(2,$cnt);
        $this->dontSeeInDatabase( 'subscriptions', [
            'user_id'     => $user_id,
            'target_id'   => $target_id,
            'target_type' => $target_type,
            'action' => 'like',
        ] );
        $this->dontSeeInDatabase( 'subscriptions', [
            'user_id'     => $user_id,
            'target_id'   => $target_id,
            'target_type' => $target_type,
            'action' => 'comment',
        ] );
    }
}
