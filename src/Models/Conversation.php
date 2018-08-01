<?php

namespace Happyphper\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * @var array
     */
    protected $table = 'chat_conversations';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * 最后的消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function last_message()
    {
        return $this->hasOne(Message::class, 'id', 'last_message_id');
    }

    /**
     * 所属用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laravel-chat.user_model'), 'user_id', 'id');
    }

    /**
     * 对方用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opponent()
    {
        return $this->belongsTo(config('laravel-chat.user_model'), 'opponent_id', 'id');
    }

    /**
     * 消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    /**
     * 消息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(MessageNotification::class, 'conversation_id', 'id');
    }
}
