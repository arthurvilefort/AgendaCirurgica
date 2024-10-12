<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['sala_nome', 'hospital_id'];
    public function tipocirurgias()
    {
        return $this->belongsToMany(Surgery_types::class, 'restricoes', 'room_id', 'surgery_type_id')->withTimestamps();
    }
}
