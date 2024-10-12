<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('pacients', function (Blueprint $table) {
            $table->id();  // Chave primária
            $table->string('nome');  // Nome do paciente
            $table->string('cpf')->unique();  // CPF do paciente
            $table->date('data_nascimento');  // Data de nascimento do paciente
            $table->string('telefone')->nullable();  // Telefone, pode ser nulo
            $table->string('endereco')->nullable();  // Endereço, pode ser nulo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacients');
    }
}
