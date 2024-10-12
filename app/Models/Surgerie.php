<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgerie extends Model
{
    use HasFactory;
    protected $primaryKey = 'cirurgia_id';

    
    protected $fillable = ['data', 'data_inicio', 'data_fim', 'hospital_id', 'sala_id', 'tipo_cirurgia_id', 'paciente_id', 'status'];


    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function sala()
    {
        return $this->belongsTo(Room::class);
    }

    public function tipoCirurgia()
    {
        return $this->belongsTo(Surgery_types::class, 'tipo_cirurgia_id');
    }

    public function pacient()
    {
        return $this->belongsTo(Pacient::class);
    }
}
