<?php

namespace App\Models;

use App\Models\Models\House;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';

    protected $fillable = ['user_id', 'house_id', 'date', 'notes'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function replacements()
    {
        return $this->hasMany(Replacement::class, 'schedule_id', 'id');
    }
}
