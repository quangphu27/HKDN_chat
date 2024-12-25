<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserJoinedRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatroomId;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatroomId, $user)
    {
        //
        $this->chatroomId = $chatroomId;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        Log::debug("User {$this->user->name} added to chat room {$this->chatroomId}");
        return new PresenceChannel('chatroom.' . $this->chatroomId);
    }
    public function broadcastWith()
    {
        return [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'avatar' => $this->user->avatar,
        ];
    }
}
