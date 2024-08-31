<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSendEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.

     */
    public function broadcastOn(): Channel
    {
//         dd($this->message->toArray());
//        return [
            return new PrivateChannel('chat-channel.'.$this->message->receiver_id);
//            new PrivateChannel('chat-channel.'.$this->message->sender_id),
//        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message->load('sender', 'receiver'),
        ];
    }
}
