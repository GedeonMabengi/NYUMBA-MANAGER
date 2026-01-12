<?php
// database/seeders/PropertyTypesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('property_types')->insert([
            [
                'name' => 'Appartement',
                'slug' => 'appartement',
                'description' => 'Logement dans un immeuble collectif',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maison',
                'slug' => 'maison',
                'description' => 'Logement individuel',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Studio',
                'slug' => 'studio',
                'description' => 'Logement avec une seule pièce principale',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Local Commercial',
                'slug' => 'local-commercial',
                'description' => 'Espace destiné à une activité commerciale',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parking',
                'slug' => 'parking',
                'description' => 'Place de stationnement',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Box de Stockage',
                'slug' => 'box-stockage',
                'description' => 'Local de stockage',
                'requires_address' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}