<?php

namespace App\Models;

use Illuminate\Bus\DynamoBatchRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'selected_id',
	'selectbed_id',
	'name',
	'address',
        'check_in',
        'check_out',
        'count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function selected()
    {
        return $this->belongsTo(Selected::class);
    }

    public function selectbed()
    {
        return $this->belongsTo(Selectbed::class);
    }

}
