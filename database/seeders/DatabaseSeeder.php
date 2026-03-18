<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@bda.mg',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Compte utilisateur 1
        User::create([
            'name'     => 'Utilisateur 1',
            'email'    => 'user1@bda.mg',
            'password' => Hash::make('user1123'),
            'role'     => 'user',
        ]);

        // Compte utilisateur 2
        User::create([
            'name'     => 'Utilisateur 2',
            'email'    => 'user2@bda.mg',
            'password' => Hash::make('user2123'),
            'role'     => 'user',
        ]);
    }
}
