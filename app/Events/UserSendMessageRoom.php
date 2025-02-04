<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserSendMessageRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $chatRoomId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $message, $chatRoomId)
    {
        //
        $this->user = $user;
        $this->message = $message;
        $this->chatRoomId = $chatRoomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }
    // public function broadcastWith()
    // {
    //     return [
    //         'user_id' => $this->user->id,
    //         'name' => $this->user->name,
    //         'avatar' => $this->user->avatar,
    //         'message' => $this->message,
    //     ];
    // }
}
