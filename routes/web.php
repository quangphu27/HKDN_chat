<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\ChatRoomUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
// use App\Http\Controllers\User\ChatAIController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\PremiumController;
use App\Http\Controllers\User\RoomController;
use App\Models\ChatRoomUser;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes([
//     'verify'=>true
// ]);
Route::get('/', function () {
    return view('home');
});

// Quên mật khẩu
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Đăng ký tài khoản
Route::get('register', [AuthController::class, 'formRegister'])->name('formRegister');
Route::post('register', [AuthController::class, 'register'])->name('register');

// Đăng nhập
Route::get('login', [AuthController::class, 'formLogin'])->name('formLogin');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Trang chủ
Route::get('home', [HomeController::class, 'index'])->name('home');

// Các trang admin truy cập
Route::group(['prefix' => 'admin', 
                'middleware' => ['auth', 'check_user:admin'], 
                'as' => 'admin.'], 
                function () {
    
    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    
    // CRUD Room
    Route::get('/roomsUser', [ChatRoomUserController::class, 'index'])->name('roomsUser.index');
    Route::get('/roomsUser/addRoom', [ChatRoomUserController::class, 'addRoom'])->name('roomsUser.addRoom');
    Route::post('/roomsUser/addRoom', [ChatRoomUserController::class, 'store'])->name('roomsUser.store');
    Route::get('/roomsUser/editRoom/{id}', [ChatRoomUserController::class, 'editRoom'])->name('roomsUser.edit');
    Route::post('/roomsUser/updateRoom/{id}', [ChatRoomUserController::class, 'update'])->name('roomsUser.update');
    Route::get('/roomsUser/deleteRoom/{id}', [ChatRoomUserController::class, 'delete'])->name('roomsUser.delete');

});
//CRUD User
Route::get('admin/user', [AdminUserController::class, 'index'])->name('admin.user.index');
Route::get('admin/user/adduser', [AdminUserController::class, 'adduser'])->name('admin.user.adduser');
Route::post('admin/user/adduser', [AdminUserController::class, 'store'])->name('admin.user.store');
Route::get('admin/user/edituser/{id}', [AdminUserController::class, 'edituser'])->name('admin.user.edit');
Route::post('admin/user/updateuser/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
Route::get('admin/user/deleteuser/{id}', [AdminUserController::class, 'delete'])->name('admin.user.delete');

// Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
// Các trang user truy cập
Route::group(['prefix' => 'user', 
                'middleware' => [ 'check_user:normal_user'], 
                'as' => 'user.'], 
                function () {

    // Profile user
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // user: ChatAI 
    Route::get('/chat/{chatRoomId?}', [ChatController::class, 'index'])->name('chat');
    Route::get('/chatAI', [ChatController::class, 'chatAI'])->name(name: 'chat.chatAI');
    Route::post('/chatAI', 'App\Http\Controllers\User\ChatAIController');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/delete/{messageId}', [ChatController::class, 'deleteMessage'])->name('chat.delete');
    Route::post('/chat/pin', [ChatController::class, 'pinMessage'])->name('chat.pin');
    Route::post('/chat/upload', [ChatController::class, 'uploadFile'])->name('chat.upload');
    // user: Tạo roomChat   
    Route::post('/chatroom/{chatRoomId}/add-user', [RoomController::class, 'addUserToChatRoom'])->name('chat.addUser');
Route::post('/chatroom/{chatRoomId}/remove-user', [RoomController::class, 'removeUserFromChatRoom'])->name('chat.removeUser');

    Route::get('/createroom', [RoomController::class, 'create'])->name('room.create');
    Route::post('/storeroom', [RoomController::class, 'store'])->name('room.store');

    // user: Tham gia roomChat
    Route::get('/joinroom', [RoomController::class, 'join'])->name('room.join');
    Route::post('/joinroom', [RoomController::class, 'joinRoom'])->name('room.joinRoom');

    Route::get('/room/getrooms', [RoomController::class, 'getRooms'])->name('room.getRooms');
    Route::post('/setroom/{chatRoomId}', [RoomController::class, 'setRoom'])->name('room.setRoom');
    Route::post('/leaveroom/{chatRoomId}', [RoomController::class, 'leaveRoom'])->name('room.leaveRoom');

    // user: payment chatRoom
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
    Route::post('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
});

// Dịch thuật
Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['vi', 'en'])) {

        App::setLocale($locale);
        session(['locale' => $locale]);
    }

    return redirect()->back();
});

// Thông báo xác minh email
Route::get('/email/verify', function () {
    return view('Emails.verify');
})->middleware('auth')->name('verification.notice');

// Trình xử lý xác minh email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Gửi lại Email xác minh
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Đăng nhập bằng google gmail
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback'])->name('callback.google');

//Tìm kiếm theo tên phòng chat
Route::get('/search', [ChatRoomUserController::class, 'search'])->name('search.result');
Route::post('/find', [ChatRoomUserController::class, 'find'])->name('search.find');
Route::get('/room/{id}', [ChatRoomUserController::class, 'show'])->name('room.show');
Route::get('/searchroom', [ChatRoomUserController::class, 'searchroom'])->name('search.result.room');
Route::get('/user/room/{id}', [ChatRoomUserController::class, 'showroom'])->name('room.user.show');
Route::get('/video/call/{roomName}', function ($roomName) {
    return view('video', ['roomName' => $roomName]);
})->name('user.video.call');
Route::post('/chat/{chatRoomId}/getNewMessages', [ChatController::class, 'getNewMessages'])->name('user.chat.getNewMessages');
