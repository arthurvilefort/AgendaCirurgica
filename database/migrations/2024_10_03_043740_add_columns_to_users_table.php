<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('crmv_cpf', 20)->nullable()->after('email');
            $table->string('contato')->nullable()->after('crmv_cpf');
            $table->tinyInteger('level')->default(0)->after('contato'); // 0: Admin, 1: Médico, 2: Paciente, 3: Funcionário
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['crmv_cpf', 'contato', 'level']);
        });
    }
}
