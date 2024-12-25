<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function formRegister()
    {
        return view('Auth/register', [
            'title' => 'Đăng ký tài khoản'
        ]);
    }

    public function register(RegisterRequest $registerRequest)
    {
        $params = $registerRequest->validated();
        $result = $this->authService->create($params);

        if ($result) {
            // Gửi email xác minh
            event(new Registered($result));

            // Đăng nhập người dùng
            Auth::login($result);

            // Điều hướng đến trang thông báo xác minh
            return redirect()->route('verification.notice');

            // return redirect()->route('formLogin')->with('verified', true);
        }

        return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
    }

    public function formLogin()
    {
        return view('Auth/login', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function login(LoginRequest $loginRequest)
    {
        // Xác thực dữ liệu đầu vào
        $params = $loginRequest->validated();

        // Xác thực người dùng bằng email và password
        if (Auth::attempt(['email' => $params['email'], 'password' => $params['password']])) {
            $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

            // Kiểm tra xem email đã được xác minh hay chưa
            if ($this->authService->checkEmailVerifyAt($user->id)) {
                // is_admin == 1 chuyển hướng đến trang admin
                if ($user->role == 'admin')
                    return redirect()->route('home');

                // is_admin == 0 chuyển hướng đến trang user
                if ($user->role == 'normal_user')
                return redirect()->route('home');

                // Nếu không phải là admin, chuyển hướng đến trang người dùng
                return redirect()->route('login');
            }

            // Gửi email xác minh
            event(new Registered($user));

            // Đăng nhập người dùng
            Auth::login($user);

            // Điều hướng đến trang thông báo xác minh
            return redirect()->route('verification.notice');
        }

        // Nếu thông tin đăng nhập không đúng
        return redirect()->back()->withErrors(['error' => 'Email hoặc mật khẩu không đúng.']);
    }

    public function logout()
    {
        $result = $this->authService->logout();

        if ($result) {
            return redirect()->route('formLogin');
        }

        return redirect()->back();
    }
}
