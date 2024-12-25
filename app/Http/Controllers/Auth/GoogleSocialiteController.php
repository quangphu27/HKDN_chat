<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('social_id', $user->id)->first();

            if($finduser){  

                Auth::login($finduser);

                return redirect()->route('home');

            }else{
                // Kiểm tra email đã được đăng ký trong hệ thống chưa
                $existingUser = User::where('email', $user->email)->first();

                if ($existingUser) {
                    $existingUser->update([
                        'social_id' => $user->id,
                        'social_type' => 'google',
                    ]);
                    
                    Auth::login($existingUser);

                    return redirect()->route('home');
                } else {
                    // Tạo mới người dùng nếu email chưa được sử dụng
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'social_id' => $user->id,
                        'social_type' => 'google',
                        'email_verified_at' => now(),
                        'password' => Str::random(16), // Mật khẩu ngẫu nhiên và mã hóa
                    ]);

                    Auth::login($newUser);

                    return redirect()->route('home');
                }
                    

                // Auth::login($newUser);

                // return redirect()->route('home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
