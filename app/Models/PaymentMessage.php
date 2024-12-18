<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMessage extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'payment_messages';

    // The attributes that are mass assignable
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'ownername',
        'number',
        'billingname',
        'price',
        'paymentmethod',
        'total',
        'fee',
        'room',
        'bed',
        'status',
    ];

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

