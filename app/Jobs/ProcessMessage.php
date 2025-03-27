<?php

namespace App\Jobs;

use App\Events\MessageProcessed;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMessage implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        // Process the message (this could be any business logic)
        $this->message->status = 'processed';  // Set message status to processed
        $this->message->save();  // Save the updated message

        // Once the message is processed, trigger the event
        broadcast(new MessageProcessed($this->message));  // Broadcast the event to notify the frontend
    }
}
