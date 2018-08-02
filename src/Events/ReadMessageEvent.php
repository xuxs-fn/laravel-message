<?php

namespace Happyphper\LaravelMessage\Events;

use Happyphper\LaravelMessage\Models\Conversation;
use Happyphper\LaravelMessage\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ReadMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Message
     */
    public $conversation;

    /**
     * Create a new event instance.
     *
     * @param Conversation $conversation
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }
}
