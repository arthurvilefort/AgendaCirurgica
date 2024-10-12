<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestricoesTable extends Migration
{
    public function up()
    {
        Schema::create('restricoes', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->unsignedBigInteger('room_id'); // FK para "rooms"
            $table->unsignedBigInteger('surgery_type_id'); // FK para "surgery_types"
            $table->timestamps();

            // Definindo as chaves estrangeiras e suas relações
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('surgery_type_id')->references('id')->on('surgery_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('restricoes');
    }
}

