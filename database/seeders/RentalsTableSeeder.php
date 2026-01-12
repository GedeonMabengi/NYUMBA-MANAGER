<?php
// database/seeders/RentalsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rentals')->insert([
            [
                'property_id' => 1, // Appartement T3 Paris 15ème
                'tenant_id' => 1, // Thomas Leroy
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'rent_amount' => 1250.00,
                'deposit_amount' => 1250.00,
                'payment_frequency' => 'monthly',
                'status' => 'active',
                'notes' => 'Contrat standard, charges comprises',
                'cancelled_at' => null,
                'cancellation_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 2, // Maison Versailles
                'tenant_id' => 3, // Antoine Petit
                'start_date' => '2023-06-01',
                'end_date' => '2024-05-31',
                'rent_amount' => 1800.00,
                'deposit_amount' => 1800.00,
                'payment_frequency' => 'monthly',
                'status' => 'active',
                'notes' => 'Jardin entretenu par le locataire',
                'cancelled_at' => null,
                'cancellation_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 3, // Studio étudiant Lyon
                'tenant_id' => 2, // Marie Moreau
                'start_date' => '2024-02-01',
                'end_date' => '2024-07-31',
                'rent_amount' => 550.00,
                'deposit_amount' => 550.00,
                'payment_frequency' => 'monthly',
                'status' => 'active',
                'notes' => 'Contrat étudiant, garant parent',
                'cancelled_at' => null,
                'cancellation_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 4, // Parking Paris 16ème
                'tenant_id' => 4, // Julie Blanc
                'start_date' => '2023-11-01',
                'end_date' => '2024-10-31',
                'rent_amount' => 120.00,
                'deposit_amount' => 240.00,
                'payment_frequency' => 'monthly',
                'status' => 'active',
                'notes' => 'Accès 24h/24 avec badge',
                'cancelled_at' => null,
                'cancellation_reason' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 5, // Local commercial Lille
                'tenant_id' => 5, // Lucas Robert
                'start_date' => '2022-03-01',
                'end_date' => '2023-12-31',
                'rent_amount' => 950.00,
                'deposit_amount' => 1900.00,
                'payment_frequency' => 'monthly',
                'status' => 'ended',
                'notes' => 'Boutique de vêtements, contrat terminé',
                'cancelled_at' => '2023-12-31',
                'cancellation_reason' => 'Fin de contrat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'property_id' => 5, // Local commercial Lille
                'tenant_id' => 6, // Sarah Durand
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-15',
                'rent_amount' => 850.00,
                'deposit_amount' => 850.00,
                'payment_frequency' => 'monthly',
                'status' => 'cancelled',
                'notes' => 'Contrat résilié prématurément',
                'cancelled_at' => '2024-03-15',
                'cancellation_reason' => 'Problèmes financiers du locataire',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}