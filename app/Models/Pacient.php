<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'telefone',
        'endereco'
    ];
    public function surgeries()
    {
        return $this->hasMany(Surgerie::class);
    }
}
