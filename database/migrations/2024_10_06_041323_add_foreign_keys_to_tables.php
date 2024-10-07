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
            $table->foreign('tipo_cirurgia_id')->references('tipo_cirurgia_id')->on('surgery_types');
            $table->foreign('sala_id')->references('id')->on('rooms');
            $table->foreign('hospital_id')->references('id')->on('hospitals');
            $table->foreign('paciente_id')->references('id')->on('users');
        });

        // Foreign key para a tabela Rooms
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals');
        });

        // Foreign key para a tabela Reports
        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals');
        });

        // Foreign keys para a tabela intermediária Hospital_User
        Schema::table('hospital_user', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals');
            $table->foreign('user_id')->references('id')->on('users');
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

        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
        });

        Schema::table('hospital_user', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
