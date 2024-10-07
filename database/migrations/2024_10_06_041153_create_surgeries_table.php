<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeriesTable extends Migration
{
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id('cirurgia_id');  // Define o campo "id" como chave primária
            $table->date('data');
            $table->unsignedBigInteger('tipo_cirurgia_id');  // FK para "surgery_types"
            $table->unsignedBigInteger('sala_id');           // FK para "rooms"
            $table->unsignedBigInteger('hospital_id');       // FK para "hospitals"
            $table->unsignedBigInteger('paciente_id');       // FK para "users" (pacientes)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}
