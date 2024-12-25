<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\{SoftDeletes};

class ChatRoom extends Model
{
    use SoftDeletes;
    /**php artisan db:seed
     * @var array
     */
    protected $fillable = ['name', 'description', 'path_image', 'available', 'capacity', 'created_at', 'updated_at', 'deleted_at', 'slug', 'invitecode', 'leader_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatRoomUsers()
    {
        return $this->hasMany(ChatRoomUser::class, 'chat_room_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }
    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'room_id')->latest();
    }

    public function setPathImageAttribute($value)
    {
        if ($value instanceof UploadedFile) {
            Storage::disk('public')->delete($this->path_image);
            $this->attributes['path_image'] = $value->storeAs('images', uniqid() . '.jpg', 'public');
        } else {
            $this->attributes['path_image'] = $value;
        }
    }
}
