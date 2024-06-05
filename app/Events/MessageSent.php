<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly int $messageId;

    public readonly int $receiverId;

    public function __construct(Message $message)
    {
        $this->messageId = $message->id;
        $this->receiverId = $message->receiver_id;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("messages.{$this->receiverId}");
    }
}
