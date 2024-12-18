<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'billing', // Add user_id to the fillable array
        'user_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
