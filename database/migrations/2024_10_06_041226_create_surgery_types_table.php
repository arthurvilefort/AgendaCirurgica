<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeryTypesTable extends Migration
{
    public function up()
    {
        Schema::create('surgery_types', function (Blueprint $table) {
            $table->id('tipo_cirurgia_id');  // Define o campo "id" como chave primária
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surgery_types');
    }
}
