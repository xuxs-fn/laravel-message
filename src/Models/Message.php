<?php

namespace Happyphper\LaravelMessage\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('laravel-message.message_table'));
    }

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
        $user = config('laravel-message');

        return $this->belongsTo($user['user_model'], 'sender_id', $user['user_id']);
    }

    /**
     * 接收者
     */
    public function recipient()
    {
        $user = config('laravel-message.user');

        return $this->belongsTo($user['user_model'], 'recipient_id', $user['user_id']);
    }
}
