<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'paymentmethod',
        'ownername',
        'number',
        'billingnameprice',
        'status',
        'total',
	'fee',
        'room',
        'bed',
        'roomMonthly',
        'bedMonthly',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
