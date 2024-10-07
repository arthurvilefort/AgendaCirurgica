<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalUserTable extends Migration
{
    public function up()
    {
        Schema::create('hospital_user', function (Blueprint $table) {
            $table->id();  // Chave primária da tabela intermediária
            $table->unsignedBigInteger('hospital_id');  // FK para "hospitals"
            $table->unsignedBigInteger('user_id');      // FK para "users"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hospital_user');
    }
}
