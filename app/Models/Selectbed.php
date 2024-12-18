<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selectbed extends Model
{
    use HasFactory;

    protected $fillable = [
	    'user_id',
        'bed_no',
        'description',
        'bed_status',
    ];


public function user()
    {
        return $this->belongsTo(User::class);
    }


}
