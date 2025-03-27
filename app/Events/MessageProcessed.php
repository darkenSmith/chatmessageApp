<?php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class MessageProcessed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // Broadcast to a private channel "user.{userId}"
    public function broadcastOn(): PrivateChannel
    {
        \Log::info($this->message);
        return new PrivateChannel('user.' . $this->message->user_id);  // Broadcasts to the user-specific channel
    }


    // Payload sent to the client
    public function broadcastWith(): array
    {
        return [
            'id'      => $this->message->id,
            'content' => $this->message->content,
            'status'  => $this->message->status,
        ];
    }

    /**
     * Get the name of the event.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'MessageProcessed';  // Event name to listen for on the frontend
    }
}
