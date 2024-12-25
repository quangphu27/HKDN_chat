<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function update($params)
    {
        try {
            $user = Auth::user(); // Lấy người dùng hiện tại
            if (!$user instanceof User) {
                abort(403, 'Unauthorized action.');
            }

            // Xử lý ảnh đại diện (avatar) nếu có
            if (isset($params['avatar']) && $params['avatar'] instanceof UploadedFile) {
                $avatar = $params['avatar'];

                // Kiểm tra phần mở rộng file hợp lệ
                if (!in_array($avatar->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                    throw new Exception('Invalid avatar file format.');
                }

                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('template/assets/img/avatar'), $avatarName);

                // Gán avatar vào params
                $params['avatar'] = $avatarName;
            }

            // Cập nhật thông tin người dùng
            $user->update($params);

            return true;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
    }
    public function updatePassword(array $data)
    {
        try {
            $user = Auth::user();

            if (!$user instanceof User) {
                abort(403, 'Unauthorized action.');
            }

            // Đặt mật khẩu mới
            $user->password = $data['newpassword'];
            $user->save();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
