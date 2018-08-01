<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 私信是一对一的关系
         */
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('last_message_id')->nullable()->comment('最后一条消息');
            $table->integer('user_id')->comment('我方');
            $table->integer('opponent_id')->comment('对方');
            $table->timestamps();

            $table->index(['user_id', 'opponent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chat_conversations');
    }
}
