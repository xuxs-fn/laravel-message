<?php

namespace Happyphper\LaravelChat\Events;

use Happyphper\LaravelChat\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Message
     */
    public $message;
    /**
     * @var Message
     */
    public $opponentMessage;

    /**
     * Create a new event instance.
     *
     * @param Message $message
     * @param Message $opponentMessage
     */
    public function __construct(Message $message, Message $opponentMessage)
    {
        $this->message = $message;
        $this->opponentMessage = $opponentMessage;
    }
}
