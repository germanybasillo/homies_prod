<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hubrental extends Model
{
	use HasFactory;
	
  
    // Allow mass assignment for these fields
    protected $fillable = [
	'user_id',    
	'name',
	'type',
         'address',
        'lat',
        'lng',
	'price',
	'status'
    ];



     public function user()
    {
        return $this->belongsTo(User::class);
     }

 public function selecteds()
    {
        return $this->hasMany(Selected::class);
    }


}
