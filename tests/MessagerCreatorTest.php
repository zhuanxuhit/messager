<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nt\Messager\Services\NotifyService;

class MessagerCreatorTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * 测试创建公告
     * @return void
     */
    public function testCreateAnnounce()
    {
        $content = 'hello-world';
        $sender_id = 12;
        NotifyService::createAnnounce($content,$sender_id);
        $this->seeInDatabase('notifies',[
           'content' => $content,
           'sender_id' => $sender_id,
        ]);
    }

    public function testCreateRemind()
    {
        $target_id = 1;
        $target_type = 'topic';
        $action = 'like';
        $sender_id = 2;
        $content = 'hello-world';
        NotifyService::createRemind($target_id,$target_type,$action,$sender_id,$content);
        $this->seeInDatabase('notifies',compact(
            'target_id','target_type','action','sender_id','content'));
    }

    public function testCreateMessage(  )
    {
        $content = 'hello-world';
        $sender_id = 1;
        $target_id = 2;
        NotifyService::createMessage($content,$sender_id,$target_id);
        $this->seeInDatabase('notifies',compact(
            'target_id','sender_id','content'));
    }

}
