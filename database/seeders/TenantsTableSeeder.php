<?php
// database/seeders/TenantsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tenants')->insert([
            [
                'user_id' => 2, // Pierre Martin
                'first_name' => 'Thomas',
                'last_name' => 'Leroy',
                'email' => 'thomas.leroy@example.com',
                'phone' => '+33612345678',
                'address' => '10 Rue de la République',
                'city' => 'Paris',
                'postal_code' => '75001',
                'id_card_number' => 'AB123456',
                'notes' => 'Employé dans une banque, dossier solide',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Pierre Martin
                'first_name' => 'Marie',
                'last_name' => 'Moreau',
                'email' => 'marie.moreau@example.com',
                'phone' => '+33623456789',
                'address' => '15 Avenue des Champs-Élysées',
                'city' => 'Paris',
                'postal_code' => '75008',
                'id_card_number' => 'CD789012',
                'notes' => 'Étudiante en master, garant parent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Sophie Dubois
                'first_name' => 'Antoine',
                'last_name' => 'Petit',
                'email' => 'antoine.petit@example.com',
                'phone' => '+33634567890',
                'address' => '5 Rue de la Paix',
                'city' => 'Versailles',
                'postal_code' => '78000',
                'id_card_number' => 'EF345678',
                'notes' => 'Ingénieur, ancien locataire fiable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Sophie Dubois
                'first_name' => 'Julie',
                'last_name' => 'Blanc',
                'email' => 'julie.blanc@example.com',
                'phone' => '+33645678901',
                'address' => '22 Boulevard Saint-Germain',
                'city' => 'Paris',
                'postal_code' => '75005',
                'id_card_number' => 'GH901234',
                'notes' => 'Médecin, cherche logement spacieux',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // Jean Dupont
                'first_name' => 'Lucas',
                'last_name' => 'Robert',
                'email' => 'lucas.robert@example.com',
                'phone' => '+33656789012',
                'address' => '8 Place de la Bourse',
                'city' => 'Bordeaux',
                'postal_code' => '33000',
                'id_card_number' => 'IJ567890',
                'notes' => 'Commercial, souvent en déplacement',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // Jean Dupont
                'first_name' => 'Sarah',
                'last_name' => 'Durand',
                'email' => 'sarah.durand@example.com',
                'phone' => '+33667890123',
                'address' => '30 Cours de l\'Intendance',
                'city' => 'Bordeaux',
                'postal_code' => '33000',
                'id_card_number' => 'KL123456',
                'notes' => 'Architecte, intéressée par le T2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}