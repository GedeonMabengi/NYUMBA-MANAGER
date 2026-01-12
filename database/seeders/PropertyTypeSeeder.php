<?php
// database/seeders/PropertyTypeSeeder.php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Maison', 'requires_address' => true],
            ['name' => 'Appartement', 'requires_address' => true],
            ['name' => 'Studio', 'requires_address' => true],
            ['name' => 'Loft', 'requires_address' => true],
            ['name' => 'Villa', 'requires_address' => true],
            ['name' => 'Local commercial', 'requires_address' => true],
            ['name' => 'Bureau', 'requires_address' => true],
            ['name' => 'Entrepôt', 'requires_address' => true],
            ['name' => 'Parking', 'requires_address' => true],
            ['name' => 'Garage', 'requires_address' => true],
            ['name' => 'Terrain', 'requires_address' => true],
            ['name' => 'Véhicule', 'requires_address' => false],
            ['name' => 'Équipement', 'requires_address' => false],
            ['name' => 'Mobilier', 'requires_address' => false],
        ];

        foreach ($types as $type) {
            PropertyType::create($type);
        }
    }
}