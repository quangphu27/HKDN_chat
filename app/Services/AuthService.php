<?php
namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService{
    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function create($param){
        try{
            $param['role']='normal_user';
            
            return $this->model->create($param);
        }
        catch (Exception $ex){
            Log::error($ex);
            return false;
        }
    }

    // Kiểm tra xem email có được xác minh hay không
    public function checkEmailVerifyAt($id)
    {
        try {
            // Tìm người dùng theo ID
            $user = $this->model->find($id);

            // Kiểm tra nếu người dùng không tồn tại hoặc email chưa được xác minh
            if (!$user || is_null($user->email_verified_at)) {
                return false; // Trả về false nếu email chưa xác minh hoặc người dùng không tồn tại
            }

            return true; // Nếu người dùng tồn tại và email đã xác minh
        } catch (Exception $ex) {
            Log::error($ex);
            return false; // Nếu có lỗi, trả về false
        }
    }

    public function forgotPass_SendMail(){
        try {

        }
        catch (Exception $ex) {
            Log::error($ex);
            return false; // Nếu có lỗi, trả về false
        }
    }

    public function logout(){
        Auth::logout();
        return true;
    }
}
