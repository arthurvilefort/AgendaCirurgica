<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();  // Define o campo "id" como chave primária padrão
            $table->string('nome');
            $table->string('endereco');
            $table->timestamps();  // Adiciona "created_at" e "updated_at"
        });
    }

    public function down()
    {
        Schema::dropIfExists('hospitals');
    }
}
