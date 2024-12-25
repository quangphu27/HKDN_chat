<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ChatRoomUserController extends Controller
{
    // Thêm (Create)
    public function addRoom()
    {   
        return view("chatroomsuser.create"); // Tìm đến create.blade.php trong thư mục chatroomsuser
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'path_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'invitecode' => 'nullable|string|unique:chat_rooms,invitecode',
            'leader_gmail' => 'required|email|exists:users,email',
        ]);
    
        // Tìm kiếm user dựa trên Gmail
        $leader = User::where('email', $validatedData['leader_gmail'])->first();
    
        // Nếu không tìm thấy user, trả về lỗi
        if (!$leader) {
            return redirect()->back()->withErrors(['leader_gmail' => 'Không tìm thấy người dùng với Gmail này.']);
        }
    
        // Tạo chat room với leader_id từ người tìm được
        $chatRoom = new ChatRoom([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? '',
            'invitecode' => $validatedData['invitecode'] ?? uniqid(),
            'leader_id' => $leader->id,
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
    
        return redirect()->back()->with('status', 'Room tạo thành công');
    }

    // Liệt kê (Read)
    public function index()
    {
        $chatrooms = ChatRoom::all();
        return view("chatroomsuser.index", compact('chatrooms')); // Hiển thị dữ liệu từ bảng chat_rooms
    }

    // Cập nhật (Update)
    public function editRoom($id)
    {
        $chatRoom = ChatRoom::find($id);
        return view('chatroomsuser.edit', compact('chatRoom'));
    }

    public function update(Request $request, $id)
    {
        $chatRoom = ChatRoom::find($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'path_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $chatRoom->name = $validatedData['name'];
        $chatRoom->description = $validatedData['description'] ?? $chatRoom->description;

        if ($request->hasFile('path_image')) {
            $oldFile = $chatRoom->path_image;
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }

            $file = $request->file('path_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/chatrooms/'), $filename);
            $chatRoom->path_image = $filename;
        }

        $chatRoom->save();

        return redirect()->back()->with('status', 'Room cập nhật thành công');
    }

    // Xóa (Delete)
    public function delete($id)
    {
        $chatRoom = ChatRoom::find($id);
        $oldFile = $chatRoom->path_image;

        if (File::exists($oldFile)) {
            File::delete($oldFile);
        }

        $chatRoom->delete();
        return redirect()->back()->with('status', 'Room xóa thành công');
    }

    //Search Room Admin
    public function search(Request $request){
        $search = $request->input('search');  
        $members = ChatRoom::where('name', 'like', "$search%")
        ->get();
        return view('Search.search-result')->with('members', $members);
        
    }
    //Find Room
    public function find(Request $request){
        $search = $request->input('search'); 
        $chatrooms = ChatRoom::where('name', 'like', "$search%")
        ->get();
        return view('Search.search-find')->with('chatrooms', $chatrooms);
        
    }
    //Show Room Admin
    public function show($id)
    {
        // Tìm phòng chat theo ID
        $room = ChatRoom::find($id);
        if (!$room) {
            abort(404, 'Room not found');
        }
        // Trả về view chi tiết phòng chat
        return view('chatroomsuser.show', compact('room'));
    }
    //Search Room User
    public function searchroom(Request $request){
        $search = $request->input('search');  
        $members = ChatRoom::where('name', 'like', "$search%")
           ->get();
        return view('Search.search-result-user')->with('members', $members);
        
    }
    //Show Room của User
    public function showroom($id)
    {
        // Tìm phòng chat theo ID
        $room = ChatRoom::find($id);
        if (!$room) {
            abort(404, 'Room not found');
        }

        // Trả về view chi tiết phòng chat
        return view('chatroomsuser.show-room-user', compact('room'));
    }
    //Search User Admin
    public function searchuser(Request $request){
        $search = $request->input('search');  
        $users = User::where('name', 'like', "$search%")
        ->get();
        return view('Search.search-user')->with('users', $users);
        
    }
}