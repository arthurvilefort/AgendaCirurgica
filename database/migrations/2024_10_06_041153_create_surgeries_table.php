<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeriesTable extends Migration
{
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id('cirurgia_id');  // Chave primária
            $table->date('data');  // Data da cirurgia
            $table->time('data_inicio');  // Hora de início da cirurgia
            $table->time('data_fim');     // Hora de término da cirurgia
            $table->unsignedBigInteger('tipo_cirurgia_id');  // FK para "surgery_types"
            $table->unsignedBigInteger('sala_id');           // FK para "rooms"
            $table->unsignedBigInteger('hospital_id');       // FK para "hospitals"
            $table->unsignedBigInteger('paciente_id');       // FK para "patients" (nova tabela de pacientes)
            $table->enum('status', ['agendada', 'realizada', 'cancelada'])->default('agendada'); // Status da cirurgia
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}
