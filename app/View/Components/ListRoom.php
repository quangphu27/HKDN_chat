<?php

namespace App\View\Components;

use App\Models\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ListRoom extends Component
{
    use SerializesModels;
    public $chatRooms;
    public $currentChatRoomId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->chatRooms = collect();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $user = auth()->user();
        if (!$user instanceof User) {
            return redirect()->back()->with('error', 'Người dùng chưa đăng nhập.');
        }
        $this->chatRooms = $user->chatRoomUsers()
            ->with(['chatRoom.latestMessage.user', 'chatRoom'])
            ->get()
            ->map(function ($chatRoomUser) use ($user) {
                $chatRoom = $chatRoomUser->chatRoom;
                $unreadMessagesCount = $chatRoom->messages()
                    ->whereDoesntHave('messageReads', function ($query) use ($user) {
                        $query->where('user_id', $user->id)->where('read', true);
                    })
                    ->count();
                return [
                    'id' => $chatRoom->id,
                    'name' => $chatRoom->name ?? 'Không tên',
                    'image' => $chatRoom->path_image ?? '/default_image.jpg',
                    'latest_message' => $chatRoom->latestMessage?->message_text ?? '',
                    'latest_message_time' => $chatRoom->latestMessage?->created_at ?? null,
                    'latest_message_sender' => $chatRoom->latestMessage?->user->name ?? 'Chưa có tin nhắn',
                    'unread_messages_count' => $unreadMessagesCount,
                ];
            });

        return view('components.list-room');
    }
}
