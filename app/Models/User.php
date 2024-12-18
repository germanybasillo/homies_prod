<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable  //implements MustVerifyEmail   
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
	'email',
        'status',
        'password',
	'user_type',
	'document',
	'valid_id',
        'number',
        'login_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'login_count' => 'integer', // Cast login_count as an integer
    ];

   /**
     * Scope a query to only include tenants.
     */
    public function scopeTenants($query)
    {
        return $query->where('user_type', 'tenant');
    }

    /**
     * Scope a query to only include rental owners.
     */
    public function scopeRentalOwners($query)
    {
        return $query->where('user_type', 'rental_owner');
    }

	/**
     * Scope a query to only include admins.
     */
    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

}
