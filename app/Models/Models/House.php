<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class House extends Model
{
    use HasFactory;
    
    protected $table = 'houses';
    
    protected $fillable = ['name'];


    public function users()
    {
        return $this->hasMany(
                User::class, 
                'house_id',
                'id');
    }
    
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'house_id', 'id');
    }
    
    public function replacements()
    {
        return $this->hasMany(Replacement::class, 'house_id', 'id');
    }
}
