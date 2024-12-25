<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $chat_room_id
 * @property integer $user_id
 * @property string $available
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property ChatRoom $chatRoom
 */
class ChatRoomUser extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['chat_room_id', 'user_id', 'available', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }
}
