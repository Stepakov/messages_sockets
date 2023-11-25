<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct( public Message $message )
    {
//        $this->message = $message->toArray();

//        dd( $this->message );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('messages_channel'),
        ];
    }

    public function broadcastAs()
    {
        return 'mes';
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->message->user->name ?? null,
            'body' => $this->message->body,
            'created_at' => $this->message->created_at->diffForHumans()
        ];
    }
}
