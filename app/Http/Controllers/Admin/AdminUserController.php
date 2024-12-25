<?php

namespace App\Http\Controllers\Admin;
use App\Mail\SendUserPassword;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    //them - Create
    public function adduser(){
       return view("admin.user.create");// tìm đến create.php trong thư mục user
    }
    public function store(Request $request){
        $user = new User();

        $user->name = $request->input('name'); 
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->password = $request->input('password');
        if ($request->hasFile('avatar')){ 
               $file = $request->file('avatar');
               $extension = $file->getClientOriginalExtension(); //lay ten mo rong .jpg .png
               $filename = time().'.'.$extension;
               $file ->move('uploads/user/',$filename); //upload lên thư mục uploads/user
               $user->avatar = 'uploads/user/'.$filename;
        }
        $validated = $request->validate([
            'name' => 'required|string|max:50|min:5',
            'email' => 'required|string|email|max:255|unique:users',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.min' => 'Tên phải có ít nhất 5 ký tự',
            'name.max' => 'Tên không được vượt quá 50 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được vượt quá 255 ký tự',
            'email.unique' => 'Email này đã được sử dụng'
        ]);
        // Tạo password random
        $password = Str::random(8); // đây là password gốc chưa hash

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $password// password đã hash để bảo mật
        ]);
        
        Mail::to($user->email)->send(new SendUserPassword($user, $password));
        
        $user->save();
        return redirect()->back()->with('status','User tạo thành công');
    }
     //lietke-Read - 
     public function index(){
        $users = User::all();
         return view("admin.user.index", compact('users'));// hiển thị dữ liệu từ bảng user
     }

    //capnhat - Update -U
    public function editUser($id){
       $user = User::find($id);
       return view('admin.user.edit', compact('user'));

    }
    
    public function update(Request $request, $id){
        $user = User::find($id);
        $user->name = $request->input('name'); 
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->about = $request->input('about');
        $user->address = $request->input('address');
        $user->password = $request->input('password');
        if($request->hasFile('avatar')){ 
            //co phai dinh kem trong form gui len khong thi tim file cu ra xoa
            //neu truoc do khong co file thi khong can xoa
            $oldfile = 'uploads/user/'.$user->avatar;
            if (File::exists($oldfile)) {
                File::delete($oldfile);
            }
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension(); //lay ten mo rong .jpg .png
            $filename = time().'.'.$extension;
            $file ->move('uploads/user/',$filename); //upload lên thư mục uploads/user
            $user->avatar = 'uploads/user/'.$filename;
        }
     $user->update();
    return redirect()->back()->with('status','User cập nhật thành công');
     }
    //xoa - Delete - D
    public function delete($id){
           $User = User::find($id);
           $oldfile = 'uploads/user/'.$User->avatar;
           if (File::exists($oldfile)) {
            File::delete($oldfile);
        }
           $User -> delete();
           return redirect()->back()->with('status','User xóa thành công');
    }

    // List Room User

}