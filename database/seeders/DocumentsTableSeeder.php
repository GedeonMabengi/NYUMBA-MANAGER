<?php
// database/seeders/DocumentsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('documents')->insert([
            [
                'rental_id' => 1,
                'name' => 'contrat-bail-t3-paris.pdf',
                'original_name' => 'Contrat de bail - Appartement T3 Paris.pdf',
                'file_path' => 'documents/rentals/1/contrat-bail-t3-paris.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 2457600,
                'document_type' => 'lease_contract',
                'uploaded_by' => 2, // Pierre Martin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 1,
                'name' => 'etat-des-lieux-entree.pdf',
                'original_name' => 'État des lieux d\'entrée.pdf',
                'file_path' => 'documents/rentals/1/etat-des-lieux-entree.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 3145728,
                'document_type' => 'inventory',
                'uploaded_by' => 2, // Pierre Martin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 2,
                'name' => 'contrat-bail-maison-versailles.pdf',
                'original_name' => 'Contrat de bail - Maison Versailles.pdf',
                'file_path' => 'documents/rentals/2/contrat-bail-maison-versailles.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 2097152,
                'document_type' => 'lease_contract',
                'uploaded_by' => 3, // Sophie Dubois
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 2,
                'name' => 'avenant-charges.pdf',
                'original_name' => 'Avenant pour charges.pdf',
                'file_path' => 'documents/rentals/2/avenant-charges.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 1048576,
                'document_type' => 'amendment',
                'uploaded_by' => 3, // Sophie Dubois
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 3,
                'name' => 'contrat-bail-studio-lyon.pdf',
                'original_name' => 'Contrat de bail étudiant - Lyon.pdf',
                'file_path' => 'documents/rentals/3/contrat-bail-studio-lyon.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 1572864,
                'document_type' => 'lease_contract',
                'uploaded_by' => 2, // Pierre Martin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 3,
                'name' => 'garant-parental.pdf',
                'original_name' => 'Garantie parentale.pdf',
                'file_path' => 'documents/rentals/3/garant-parental.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 1310720,
                'document_type' => 'other',
                'uploaded_by' => 2, // Pierre Martin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 4,
                'name' => 'contrat-parking-paris.pdf',
                'original_name' => 'Contrat de location parking.pdf',
                'file_path' => 'documents/rentals/4/contrat-parking-paris.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 1048576,
                'document_type' => 'lease_contract',
                'uploaded_by' => 4, // Jean Dupont
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rental_id' => 5,
                'name' => 'contrat-local-commercial.pdf',
                'original_name' => 'Contrat bail commercial.pdf',
                'file_path' => 'documents/rentals/5/contrat-local-commercial.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 3145728,
                'document_type' => 'lease_contract',
                'uploaded_by' => 3, // Sophie Dubois
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}