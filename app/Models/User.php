<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\UploadedFile;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone_number',
        'plain_password',  // Thêm vào fillable
        'role',
        'about',
        'avatar',
        'social_id',
        'social_type',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function canCreateGroup()
    {
        if ($this->isPremium) {
            return true;
        }
        $maxGroups = 3;
        return $this->chatRoomsAsLeader()->count() < $maxGroups;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function setAvatarAttribute($value)
    {
        if ($value && $this->avatar && $this->avatar !== $value) {
            $oldAvatarPath = public_path('template/assets/img/avatar/' . $this->avatar);
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }
        $this->attributes['avatar'] = $value;
    }
    public function chatRoomUsers()
    {
        return $this->hasMany(ChatRoomUser::class, 'user_id');
    }
    public function setIsPremiumAttribute($value)
    {
        $this->attributes['isPremium'] = $value ? true : false;
    }

    public function chatRoomsAsLeader()
    {
        return $this->hasMany(ChatRoom::class, 'leader_id');
    }
    public function chatRooms()
    {
        return $this->hasMany(ChatRoomUser::class, 'user_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }
    public function messageReads()
    {
        return $this->hasMany(MessageRead::class);
    }
}
