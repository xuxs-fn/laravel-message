<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_message_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned()->comment('会话');
            $table->integer('message_id')->unsigned()->comment('消息');
            $table->integer('user_id')->unsigned()->comment('被提醒用户');
            $table->boolean('is_seen')->default(false)->comment('是否查看');
            $table->timestamps();

            $table->unique(['user_id', 'conversation_id', 'message_id'], 'unique_user_conversation_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chat_message_notifications');
    }
}
