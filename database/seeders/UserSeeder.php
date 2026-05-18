<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'prueba',
            'email' => 'prueba@prueba.com',
            'password' => Hash::make('12345678'),
            'description' => 'usuario de prueba',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'claudio',
            'email' => 'claudio@claudio.com',
            'password' => Hash::make('12345678'),
            'description' => 'usuario de prueba fotografo',
            'role' => 'photographer',
        ]);
    }
}