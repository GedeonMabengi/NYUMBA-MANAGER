<?php
// database/seeders/PropertiesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('properties')->insert([
            [
                'name' => 'Appartement T3 Paris 15ème',
                'description' => 'Bel appartement lumineux avec balcon',
                'property_type_id' => 1, // Appartement
                'user_id' => 2, // Pierre Martin
                'address' => '25 Rue du Commerce',
                'city' => 'Paris',
                'postal_code' => '75015',
                'country' => 'France',
                'is_for_rent' => true,
                'status' => 'available',
                'surface' => 65.50,
                'rooms' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maison avec jardin à Versailles',
                'description' => 'Maison de ville avec jardin privatif',
                'property_type_id' => 2, // Maison
                'user_id' => 3, // Sophie Dubois
                'address' => '15 Avenue de Paris',
                'city' => 'Versailles',
                'postal_code' => '78000',
                'country' => 'France',
                'is_for_rent' => true,
                'status' => 'rented',
                'surface' => 120.00,
                'rooms' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Studio étudiant Lyon 7ème',
                'description' => 'Studio rénové proche université',
                'property_type_id' => 3, // Studio
                'user_id' => 2, // Pierre Martin
                'address' => '8 Rue de l\'Université',
                'city' => 'Lyon',
                'postal_code' => '69007',
                'country' => 'France',
                'is_for_rent' => true,
                'status' => 'available',
                'surface' => 25.00,
                'rooms' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parking couvert Paris 16ème',
                'description' => 'Parking sécurisé avec badge',
                'property_type_id' => 5, // Parking
                'user_id' => 4, // Jean Dupont
                'address' => '45 Avenue Victor Hugo',
                'city' => 'Paris',
                'postal_code' => '75016',
                'country' => 'France',
                'is_for_rent' => true,
                'status' => 'available',
                'surface' => 12.00,
                'rooms' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Local commercial Lille',
                'description' => 'Local vitrine idéal pour boutique',
                'property_type_id' => 4, // Local Commercial
                'user_id' => 3, // Sophie Dubois
                'address' => '22 Rue de la Grande Chaumière',
                'city' => 'Lille',
                'postal_code' => '59000',
                'country' => 'France',
                'is_for_rent' => true,
                'status' => 'unavailable',
                'surface' => 85.00,
                'rooms' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Appartement T2 Bordeaux',
                'description' => 'Appartement neuf quartier historique',
                'property_type_id' => 1, // Appartement
                'user_id' => 4, // Jean Dupont
                'address' => '12 Rue Sainte-Catherine',
                'city' => 'Bordeaux',
                'postal_code' => '33000',
                'country' => 'France',
                'is_for_rent' => false,
                'status' => 'available',
                'surface' => 45.00,
                'rooms' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}