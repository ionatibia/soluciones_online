<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;
use App\Models\Service;
use App\Models\Message;

class NewChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Chat $chat, public Service $service, public Message $message)
    {
        //
    }

    public function broadcastOn(): array
    {
        // $this->message is available here
        return [
            /* new PrivateChannel("servicios"), */
            new Channel("newchat")
        ];
    }
}
