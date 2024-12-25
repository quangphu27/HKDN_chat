<?php

namespace App\Http\Controllers\User;

use App\Events\UserJoinedRoom;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    //
    public function create()
    {
        $user = Auth::user();
        $chatRooms = $user->chatRoomsAsLeader;
        return view('User.Room.createroom', compact('chatRooms'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user instanceof User) {
            if (!$user || !$user->canCreateGroup()) {
                return redirect()->back()->with('error', 'Bạn đã hết lượt tạo nhóm. Vui lòng nâng cấp tài khoản hoặc xóa nhóm cũ.');
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'path_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'invitecode' => 'nullable|string|unique:chat_rooms,invitecode',
            ]);

            $chatRoom = new ChatRoom([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? '',
                'leader_id' => $user->id,
                'invitecode' => $validatedData['invitecode'] ?? uniqid(),
            ]);

            if ($request->hasFile('path_image')) {
                $file = $request->file('path_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/chatrooms/'), $filename);
                $chatRoom->path_image = $filename;
            } else {
                $chatRoom->path_image = '/default_image.jpg';
            }

            $chatRoom->save();
            $chatRoom->chatRoomUsers()->create([
                'user_id' => $user->id,
                'available' => 'YES',
            ]);
            $message = $chatRoom->messages()->create([
                'message_text' => $chatRoom->name . ' đã được tạo bởi ' . $user->name,
                'user_id' => $user->id,
            ]);

            $chatRoom->chatRoomUsers()->each(function ($chatRoomUser) use ($message, $user) {
                if ($chatRoomUser->user_id != $user->id) {
                    $message->messageReads()->create([
                        'user_id' => $chatRoomUser->user_id,
                        'read' => false,
                    ]);
                }
            });

            return redirect()->route('user.room.create')->with('success', 'Nhóm đã được tạo thành công.');
        }
    }

    public function join()
    {
        return view('User.Room.joinroom');
    }
    public function joinRoom(Request $request)
    {
        $validatedData = $request->validate([
            'invitecode' => 'required|string',
        ]);


        $chatRoom = ChatRoom::where('invitecode', $validatedData['invitecode'])->first();
        if ($chatRoom) {
            $user = Auth::user();

            if ($user instanceof User) {
                $existingJoin = ChatRoomUser::where('chat_room_id', $chatRoom->id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($existingJoin) {
                    return redirect()->back()->with('success', 'Bạn đã tham gia nhóm này rồi.');
                }

                ChatRoomUser::create([
                    'chat_room_id' => $chatRoom->id,
                    'user_id' => $user->id,
                ]);
                broadcast(new UserJoinedRoom($chatRoom->id, $user))->toOthers();

                return redirect()->back()->with('success', 'Tham gia nhóm thành công.');
            }
        } else {
            return redirect()->back()->with('error', 'Nhóm không tồn tại.');
        }

        return redirect()->back()->with('error', 'Không thể tham gia nhóm.');
    }
    public function leaveRoom($chatRoomId)
    {
        $user = Auth::user();
        $chatRoom = ChatRoom::find($chatRoomId);

        if ($chatRoom) {
            $chatRoomUser = ChatRoomUser::where('chat_room_id', $chatRoom->id)
                ->where('user_id', $user->id)
                ->first();

            if ($chatRoomUser) {
                $chatRoomUser->delete();
                return redirect()->back()->with('success', 'Rời nhóm thành công.');
            }
        }

        return redirect()->back()->with('error', 'Không thể rời nhóm.');
    }

    public function getRooms()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Người dùng chưa đăng nhập.');
        }

        $chatRooms = $user->chatRoomUsers()
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
            })
            ->sortByDesc('latest_message_time')  // Sắp xếp theo thời gian của tin nhắn cuối cùng (mới nhất trước)
            ->values(); // Đảm bảo các chỉ số mảng được reset lại sau khi sắp xếp

        return response()->json($chatRooms);
    }
    public function setRoom($chatRoomId)
    {
        $user = auth()->user();
        $chatRoom = $user->chatRoomUsers()
            ->where('chat_room_id', $chatRoomId)
            ->first();

        if (!$chatRoom) {
            return response()->json(['status' => 'error', 'message' => 'Chat room not found'], 404);
        }

        // Đánh dấu tất cả tin nhắn trong phòng chat là chưa đọc (read = false)
        $chatRoom->chatRoom->messages()->each(function ($message) use ($user) {
            $messageRead = $message->messageReads()->firstOrNew(['user_id' => $user->id]);
            $messageRead->read = true;
            $messageRead->save();
        });

        return response()->json(['status' => 'success']);
    }
}