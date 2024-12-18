<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenantprofile extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'email',
        'contact',
        'address',
        'gender',
        'user_id' // Add user_id to the fillable array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
