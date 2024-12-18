<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'selectbed_id',
        'user_id' // Add user_id to the fillable array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function selectbed()
    {
        return $this->belongsTo(Selectbed::class);
    }
    
}
