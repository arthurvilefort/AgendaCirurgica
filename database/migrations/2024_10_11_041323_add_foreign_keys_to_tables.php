<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTables extends Migration
{
    public function up()
    {
        // Foreign keys para a tabela Surgeries
        Schema::table('surgeries', function (Blueprint $table) {
            $table->foreign('tipo_cirurgia_id')->references('id')->on('surgery_types')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacients')->onDelete('cascade');  // FK para a tabela pacients
        });

        // Foreign key para a tabela Rooms
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });

        // Foreign keys para a tabela intermediária Hospital_User
        Schema::table('hospital_user', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('surgeries', function (Blueprint $table) {
            $table->dropForeign(['tipo_cirurgia_id']);
            $table->dropForeign(['sala_id']);
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['paciente_id']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
        });

        Schema::table('hospital_user', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
