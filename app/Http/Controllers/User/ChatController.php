<?php

namespace App\Http\Controllers\User;

use App\Events\UserSendMessageRoom;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\Message;
use App\Models\MessageRead;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getNewMessages(Request $request, $chatRoomId)
{
    $lastMessageId = $request->input('lastMessageId', 0); // ID của tin nhắn cuối cùng đã hiển thị.

    $newMessages = Message::where('chat_room_id', $chatRoomId)
        ->where('id', '>', $lastMessageId)
        ->with('user:id,name,avatar') // Lấy thông tin người gửi.
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json(['newMessages' => $newMessages]);
}

    public function chatAI()
    {
        // Trả về view tạo giao diện chat AI
        return view('User.Chat.chatAI');
    }

    public function index($chatRoomId = null)
    {
        $chatRoom = null;
        $messages = [];
        $usersInRoom = []; // Danh sách người dùng trong phòng chat

        if ($chatRoomId) {
            $chatRoom = ChatRoom::find($chatRoomId); // Sử dụng ChatRoom::find thay vì ChatRoomUser::find
            if ($chatRoom) {
                // Lấy tin nhắn
                $messages = $chatRoom->messages()
                    ->with([
                        'user' => function ($query) {
                            $query->select('id', 'name', 'avatar');
                        }
                    ])
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Lấy người dùng trong phòng chat
                $usersInRoom = $chatRoom->users ?: collect(); // Nếu không có người dùng trong phòng chat thì trả về một collection rỗng

                // Lấy danh sách tất cả người dùng trừ những người trong phòng chat
                $allUsers = User::whereNotIn('id', $usersInRoom->pluck('id'))->get();
            }
        }

        // Trả về view phòng chat với các thông tin
        return view('User.Chat.chat', compact('chatRoom', 'messages', 'usersInRoom', 'allUsers'));
    }

    public function addUserToChatRoom(Request $request, $chatRoomId)
    {
        $chatRoom = ChatRoom::find($chatRoomId);
        $userId = $request->input('user_id');
        
        if ($chatRoom && $userId) {
            $user = User::find($userId);
            if ($user) {
                // Thêm người dùng vào phòng chat
                $chatRoom->users()->attach($user);
                return response()->json(['status' => 'success']);
            }
        }
    
        return response()->json(['status' => 'error']);
    }

    public function removeUserFromChatRoom(Request $request, $chatRoomId)
    {
        $chatRoom = ChatRoom::find($chatRoomId);
        $userId = $request->input('user_id');
    
        if ($chatRoom && $userId) {
            // Xóa người dùng khỏi phòng chat
            $chatRoom->users()->detach($userId);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $message = $request->post('message');
        $chatRoomId = $request->post('chatRoomId');

        $newMessage = Message::create([
            'room_id' => $chatRoomId,
            'user_id' => $user->id,
            'message_text' => $message,
        ]);

        // Lấy danh sách người dùng trong phòng chat
        $chatRoomUsers = ChatRoom::find($chatRoomId)->chatRoomUsers()->get();

        foreach ($chatRoomUsers as $chatRoomUser) {
            $isRead = ($chatRoomUser->user->id === $newMessage->user_id) ? true : false;

            MessageRead::create([
                'user_id' => $chatRoomUser->user->id,
                'message_id' => $newMessage->id,
                'read' => $isRead,
            ]);
        }
        
        broadcast(new UserSendMessageRoom($user, $message, $chatRoomId));
        
        return response()->json(['status' => 'success']);
    }

    public function deleteMessage(Request $request)
    {
        $messageId = $request->post('messageId');
        $message = Message::find($messageId);

        if ($message && $message->user_id === auth()->id()) {
            // Xóa tin nhắn
            $message->delete();

            // Xóa các bản ghi trong bảng MessageRead liên quan đến tin nhắn đã xóa
            MessageRead::where('message_id', $messageId)->delete();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Message not found or you don\'t have permission to delete this message']);
    }

    public function pinMessage(Request $request)
    {
        $messageId = $request->post('messageId');
        $message = Message::find($messageId);

        if ($message) {
            // Ghim tin nhắn trong nhóm
            $chatRoom = $message->chatRoom;
            $chatRoom->pinned_message_id = $messageId;
            $chatRoom->save();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Message not found']);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Giới hạn file 10MB
            'chatRoomId' => 'required|exists:chat_rooms,id',
        ]);

        $file = $request->file('file');
        $chatRoomId = $request->post('chatRoomId');

        // Lưu file vào thư mục uploads/chatfiles
        $filePath = $file->store('uploads/chatfiles', 'public');

        // Tạo bản ghi tin nhắn cho file đã gửi
        $message = Message::create([
            'room_id' => $chatRoomId,
            'user_id' => auth()->id(),
            'file_path' => $filePath,
        ]);

        // Thêm bản ghi MessageRead cho mỗi người dùng trong nhóm
        $chatRoomUsers = ChatRoom::find($chatRoomId)->chatRoomUsers()->get();

        foreach ($chatRoomUsers as $chatRoomUser) {
            MessageRead::create([
                'user_id' => $chatRoomUser->user->id,
                'message_id' => $message->id,
                'read' => ($chatRoomUser->user->id === $message->user_id) ? true : false,
            ]);
        }

        return response()->json(['status' => 'success', 'filePath' => $filePath]);
    }
}
