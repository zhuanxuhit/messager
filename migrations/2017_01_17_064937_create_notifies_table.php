<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->unsignedSmallInteger('type');// 消息的类型，1: 公告 Announce，2: 提醒 Remind，3：信息 Message
            $table->unsignedInteger('target_id')->default(0);
            $table->string('target_type')->default('');
            $table->string('action')->default('');
            $table->unsignedInteger('sender_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifies');
    }
}
