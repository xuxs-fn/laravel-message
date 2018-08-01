<?php

namespace Happyphper\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;

class MessageNotification extends Model
{
    /**
     * @var string
     */
    protected $table = 'chat_message_notifications';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 会话
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function conversation()
    {
        return $this->hasOne(Conversation::class, 'conversation_id', 'id');
    }

    /**
     * 消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }

    /**
     * 用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laravel-chat.user_model'), 'opponent', config('laravel-chat.user_id'));
    }
}
