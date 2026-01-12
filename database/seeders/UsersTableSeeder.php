<?php
// database/seeders/UsersTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            // Administrateur
            [
                'name' => 'Admin Principal',
                'email' => 'admin@systeme-location.fr',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33123456789',
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Bailleurs
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33612345678',
                'role' => 'bailleur',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophie Dubois',
                'email' => 'sophie.dubois@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33623456789',
                'role' => 'bailleur',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33634567890',
                'role' => 'bailleur',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Avocats
            [
                'name' => 'Maître Bernard',
                'email' => 'maitre.bernard@avocat.fr',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33198765432',
                'role' => 'avocat',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maître Laurent',
                'email' => 'maitre.laurent@avocat.fr',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'phone' => '+33187654321',
                'role' => 'avocat',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}