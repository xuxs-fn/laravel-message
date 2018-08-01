<?php

namespace Happyphper\LaravelChat\Listeners;

use Happyphper\LaravelChat\Models\Conversation;
use Illuminate\Contracts\Queue\ShouldQueue;

class LastMessageListener implements ShouldQueue
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
        Conversation::find($event->message->conversation_id)->update(['last_message_id' => $event->message->id]);
        Conversation::find($event->opponentMessage->conversation_id)->update(['last_message_id' => $event->opponentMessage->id]);
    }
}
