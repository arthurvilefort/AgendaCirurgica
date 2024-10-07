<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'level' => 0, // Administrador
            'crmv_cpf' => '00000000000',
            'contato' => '0000-0000',
        ]);

        User::create([
            'name' => 'Médico',
            'email' => 'medico@medico.com',
            'password' => Hash::make('admin123'),
            'level' => 1, // Médico
            'crmv_cpf' => '11111111111',
            'contato' => '1111-1111',
        ]);

        User::create([
            'name' => 'Funcionário',
            'email' => 'funcionario@funcionario.com',
            'password' => Hash::make('admin123'),
            'level' => 2, // Funcionário
            'crmv_cpf' => '22222222222',
            'contato' => '2222-2222',
        ]);
    }
}
