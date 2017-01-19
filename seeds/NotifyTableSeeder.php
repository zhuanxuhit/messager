<?php

use Illuminate\Database\Seeder;
use Nt\Messager\Notify;
use Nt\Messager\UserNotify;

class NotifyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notify::truncate();
        UserNotify::truncate();
        factory( Notify::class, 50)->create()
            ->each(function( Notify $notify){
            $notify->userNotifies()->save(factory( UserNotify::class)->make(['notify_type'=>$notify->type]));
        });
    }
}
