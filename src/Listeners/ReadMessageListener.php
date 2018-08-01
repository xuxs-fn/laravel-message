<?php

namespace Happyphper\LaravelChat\Listeners;

use Happyphper\LaravelChat\Models\MessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReadMessageListener implements ShouldQueue
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
        MessageNotification::where('conversation_id', $event->conversation->id)
            ->where('is_seen', 0)->update(['is_seen' => 1]);
    }
}
