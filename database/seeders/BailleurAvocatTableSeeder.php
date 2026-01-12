<?php
// database/seeders/BailleurAvocatTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BailleurAvocatTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bailleur_avocat')->insert([
            [
                'bailleur_id' => 2, // Pierre Martin
                'avocat_id' => 5, // Maître Bernard
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bailleur_id' => 2, // Pierre Martin
                'avocat_id' => 6, // Maître Laurent
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bailleur_id' => 3, // Sophie Dubois
                'avocat_id' => 5, // Maître Bernard
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bailleur_id' => 3, // Sophie Dubois
                'avocat_id' => 6, // Maître Laurent
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bailleur_id' => 4, // Jean Dupont
                'avocat_id' => 5, // Maître Bernard
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bailleur_id' => 4, // Jean Dupont
                'avocat_id' => 6, // Maître Laurent
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}