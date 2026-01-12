<?php
// app/Http/Controllers/Avocat/DocumentController.php

namespace App\Http\Controllers\Avocat;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        $rental = $document->rental;
        $property = $rental->property;
        $bailleur = $property->owner;

        // Vérifier que l'avocat est associé au bailleur propriétaire du bien
        if (!auth()->user()->bailleurs()->where('bailleur_id', $bailleur->id)->exists()) {
            abort(403);
        }

        return Storage::disk('private')->download(
            $document->file_path,
            $document->original_name
        );
    }

    public function view(Document $document)
    {
        $rental = $document->rental;
        $property = $rental->property;
        $bailleur = $property->owner;

        if (!auth()->user()->bailleurs()->where('bailleur_id', $bailleur->id)->exists()) {
            abort(403);
        }

        return response()->file(
            Storage::disk('private')->path($document->file_path)
        );
    }
}