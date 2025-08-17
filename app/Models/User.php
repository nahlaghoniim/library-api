<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
/**
 * @property string $role
 * @method bool isAdmin()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime','password'=>'hashed'];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Admin helper
  public function isAdmin()
    {
        // Adjust this logic based on your application's admin identification
        return $this->role === 'admin';
    }
}