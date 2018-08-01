<?php

namespace Happyphper\LaravelChat\Listeners;

use Happyphper\LaravelChat\Models\MessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessageListener implements ShouldQueue
{
    /**
     * 任务应该发送到的队列的名称
     *
     * @var string|null
     */
    public $queue = 'chat:listeners';

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        MessageNotification::create([
            'conversation_id' => $event->message->conversation_id,
            'message_id' => $event->opponentMessage->id,
            'user_id' => $event->message->recipient_id,
        ]);
    }
}
