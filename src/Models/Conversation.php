<?php

namespace Happyphper\LaravelMessage\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-message.conversation_table'));
    }

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
        $user = config('laravel-message');

        return $this->belongsTo($user['user_model'], 'user_id', $user['user_id']);
    }

    /**
     * 对方用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opponent()
    {
        $user = config('laravel-message');

        return $this->belongsTo($user['user_model'], 'opponent_id', $user['user_id']);
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
