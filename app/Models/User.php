<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Models\House;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
//    const AVAILABLE = 1;
//    const UNAVAILABLE = 0;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'house_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function isEnabled() 
    {
        return $this->status == self::STATUS_ENABLED;
        
    }
    
    public function isDisabled() 
    {
        return $this->status == self::STATUS_DISABLED;
    }
    
//    public function isAvailable()
//    {
//        return $this->availability == self::AVAILABLE;
//    }
// 
//    public function isNotAvailable()
//    {
//        return $this->availability == self::UNAVAILABLE;
//    }

    public function house()
    {
        return $this->belongsTo(
                    House::class, 
                    'house_id', 
                    'id');
    }
    
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'user_id', 'id');
    }
    
    public function replacements()
    {
        return $this->hasMany(Replacement::class, 'user_id', 'id');
    }
}
