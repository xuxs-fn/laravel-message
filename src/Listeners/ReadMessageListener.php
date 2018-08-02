<?php

namespace Happyphper\LaravelMessage\Listeners;

use Happyphper\LaravelMessage\Models\MessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReadMessageListener implements ShouldQueue
{
    /**
     * 任务应该发送到的队列的名称
     *
     * @var string|null
     */
    public $queue = 'laravel-message';

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
