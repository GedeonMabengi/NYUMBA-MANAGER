<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\UsersTableSeeder::class,
            \Database\Seeders\PropertyTypesTableSeeder::class,
            \Database\Seeders\PropertiesTableSeeder::class,
            \Database\Seeders\BailleurAvocatTableSeeder::class,
            \Database\Seeders\TenantsTableSeeder::class,
            \Database\Seeders\RentalsTableSeeder::class,
            \Database\Seeders\DocumentsTableSeeder::class,
            \Database\Seeders\ActivityLogsTableSeeder::class,
        ]);
    }
}