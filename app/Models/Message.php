<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'user_id', 'message_text', 'status', 'file_url', 'created_at', 'updated_at'];
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function messageReads()
    {
        return $this->hasMany(MessageRead::class, 'message_id');
    }
}
