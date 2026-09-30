<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'AdminGhost',
            'email' => 'admin@ejemplo.com',
            'password' => Hash::make('password123'), // Contraseña hasheada
        ]);

        User::create([
            'name' => 'SniperElite',
            'email' => 'jugador@ejemplo.com',
            'password' => Hash::make('password123'),
        ]);
    }
}