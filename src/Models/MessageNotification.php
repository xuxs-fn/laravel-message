<?php

namespace Happyphper\LaravelMessage\Models;

use Illuminate\Database\Eloquent\Model;

class MessageNotification extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-message.message_notification_table'));
    }

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
        return $this->belongsTo(config('laravel-message.user_model'), 'opponent_id', config('laravel-message.user_id'));
    }
}
