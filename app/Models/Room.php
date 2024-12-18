<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'selected_id',
        'start_date',
        'due_date',
        'user_id' // Add user_id to the fillable array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function selected()
    {
        return $this->belongsTo(Selected::class);
    }
}
