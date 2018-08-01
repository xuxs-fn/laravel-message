<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 当发送私信时，默认存入两条数据。这是为了兼容一方删除，另一方未删除的状况。
         */
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned()->comment('会话');
            $table->integer('sender_id')->unsigned()->comment('发送人');
            $table->integer('recipient_id')->unsigned()->comment('接收人');
            $table->string('type')->default('text')->comment('类型：默认为文本');
            $table->text('body')->comment('消息体');
            $table->timestamps();

            $table->index(['conversation_id', 'sender_id', 'recipient_id'], 'index_conversation_sender_recipient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chat_messages');
    }
}
