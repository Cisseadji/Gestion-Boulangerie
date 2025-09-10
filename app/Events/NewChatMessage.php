<?php

namespace App\Events;

use App\Models\chat_message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct(chat_message $message)
    {
        $this->message = $message->load(['expediteur']);
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->id_destinataire);
    }
}
