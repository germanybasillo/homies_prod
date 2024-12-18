<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'content'];

    // Relationship with the sender (User model)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship with the receiver (User model)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
