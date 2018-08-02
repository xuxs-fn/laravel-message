<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelMessageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-message');

        /**
         * 私信被设置为一对一的关系
         */
        Schema::create($config['conversation_table'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('last_message_id')->nullable()->comment('最后一条消息');
            $table->integer('user_id')->comment('我方');
            $table->integer('opponent_id')->comment('对方');
            $table->timestamps();

            $table->index(['user_id', 'opponent_id']);
        });

        /**
         * 当发送私信时，默认存入两条数据。这是为了兼容一方删除，另一方未删除的状况。
         */
        Schema::create($config['message_table'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned()->comment('会话');
            $table->integer('sender_id')->comment('发送人');
            $table->integer('recipient_id')->comment('接收人');
            $table->string('type')->default('text')->comment('类型：默认为文本');
            $table->text('body')->comment('消息体');
            $table->timestamps();

            $table->index(['conversation_id', 'sender_id', 'recipient_id'], 'index_conversation_sender_recipient');
        });

        /**
         * 仅收信人能够得到提醒
         */
        Schema::create($config['message_notification_table'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned()->comment('会话');
            $table->integer('message_id')->unsigned()->comment('消息');
            $table->integer('user_id')->comment('被提醒用户');
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
        $config = config('laravel-message');

        Schema::dropIfExists($config['conversation_table']);
        Schema::dropIfExists($config['message_table']);
        Schema::dropIfExists($config['message_notification_table']);
    }
}
