<?php
// database/seeders/ActivityLogsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activity_logs')->insert([
            [
                'user_id' => 2, // Pierre Martin
                'action' => 'created',
                'model_type' => 'App\\Models\\Property',
                'model_id' => 1,
                'old_values' => null,
                'new_values' => json_encode(['name' => 'Appartement T3 Paris 15ème', 'status' => 'available']),
                'ip_address' => '192.168.1.100',
                'created_at' => '2024-01-10 09:30:00',
                'updated_at' => '2024-01-10 09:30:00',
            ],
            [
                'user_id' => 2, // Pierre Martin
                'action' => 'created',
                'model_type' => 'App\\Models\\Rental',
                'model_id' => 1,
                'old_values' => null,
                'new_values' => json_encode(['property_id' => 1, 'tenant_id' => 1, 'status' => 'active']),
                'ip_address' => '192.168.1.100',
                'created_at' => '2024-01-15 14:20:00',
                'updated_at' => '2024-01-15 14:20:00',
            ],
            [
                'user_id' => 3, // Sophie Dubois
                'action' => 'updated',
                'model_type' => 'App\\Models\\Property',
                'model_id' => 2,
                'old_values' => json_encode(['status' => 'available']),
                'new_values' => json_encode(['status' => 'rented']),
                'ip_address' => '192.168.1.101',
                'created_at' => '2023-06-01 10:15:00',
                'updated_at' => '2023-06-01 10:15:00',
            ],
            [
                'user_id' => 3, // Sophie Dubois
                'action' => 'rental_started',
                'model_type' => 'App\\Models\\Rental',
                'model_id' => 2,
                'old_values' => null,
                'new_values' => json_encode(['start_date' => '2023-06-01', 'status' => 'active']),
                'ip_address' => '192.168.1.101',
                'created_at' => '2023-06-01 11:00:00',
                'updated_at' => '2023-06-01 11:00:00',
            ],
            [
                'user_id' => 4, // Jean Dupont
                'action' => 'created',
                'model_type' => 'App\\Models\\Tenant',
                'model_id' => 5,
                'old_values' => null,
                'new_values' => json_encode(['first_name' => 'Lucas', 'last_name' => 'Robert']),
                'ip_address' => '192.168.1.102',
                'created_at' => '2023-12-05 16:45:00',
                'updated_at' => '2023-12-05 16:45:00',
            ],
            [
                'user_id' => 5, // Maître Bernard
                'action' => 'updated',
                'model_type' => 'App\\Models\\Rental',
                'model_id' => 5,
                'old_values' => json_encode(['status' => 'active']),
                'new_values' => json_encode(['status' => 'ended', 'cancelled_at' => '2023-12-31']),
                'ip_address' => '192.168.1.103',
                'created_at' => '2023-12-31 09:00:00',
                'updated_at' => '2023-12-31 09:00:00',
            ],
            [
                'user_id' => 6, // Maître Laurent
                'action' => 'rental_ended',
                'model_type' => 'App\\Models\\Rental',
                'model_id' => 6,
                'old_values' => json_encode(['status' => 'active']),
                'new_values' => json_encode(['status' => 'cancelled', 'cancellation_reason' => 'Problèmes financiers']),
                'ip_address' => '192.168.1.104',
                'created_at' => '2024-03-15 15:30:00',
                'updated_at' => '2024-03-15 15:30:00',
            ]
        ]);
    }
}