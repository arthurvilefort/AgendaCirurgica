<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgery_types extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'desc'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'restricoes', 'surgery_type_id', 'room_id')->withTimestamps();
    }
}
