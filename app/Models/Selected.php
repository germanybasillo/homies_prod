<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selected extends Model
{
    use HasFactory;

    protected $fillable = [
	'user_id',
        'hubrental_id',
        'room_no',
        'description',
        'profile1',
        'profile2',
        'profile3',
        'profile4',
        'profile5',
        'profile6',
        'caption1',
        'caption2',
        'caption3',
        'caption4',
        'caption5',
	'caption6',
	'bed_no',
	'bed_status',	
    ];

  public function user()
    {
        return $this->belongsTo(User::class);
    }

public function hubrental()
    {
        return $this->belongsTo(Hubrental::class);
    }


}
