<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifies', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_read')->default(false);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('notify_id');
            $table->unsignedSmallInteger('notify_type');
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
        Schema::dropIfExists('user_notifies');
    }
}
