<?php

namespace Happyphper\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var string
     */
    protected $table = 'chat_messages';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 会话
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    /**
     * 发送者
     */
    public function sender()
    {
        return $this->belongsTo(config('laravel-chat.user_model'), 'sender_id', config('laravel-chat.user_id'));
    }

    /**
     * 接收者
     */
    public function recipient()
    {
        return $this->belongsTo(config('laravel-chat.user_model'), 'recipient_id', config('laravel-chat.user_id'));
    }
}
