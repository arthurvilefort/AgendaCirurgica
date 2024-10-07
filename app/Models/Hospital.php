<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'endereco'];

    // Relacionamento muitos para muitos com usuários
    public function users()
    {
        return $this->belongsToMany(User::class, 'hospital_user', 'hospital_id', 'user_id');
    }
}
