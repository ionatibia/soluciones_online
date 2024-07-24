<?php

use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('servicios.{servicio}', function (User $user, $chat) {
    $chat = Chat::where('id', (int)$chat)->first();
    $first_message = Message::where('chat_id', $chat->id)->first();
    return $user->id === $first_message->to || $user->id === $first_message->from;
});

Broadcast::channel('newchat', function (User $user, $chat) {
    return true;
});
