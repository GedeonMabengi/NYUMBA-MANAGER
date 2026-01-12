<?php
// app/Http/Controllers/Bailleur/AvocatController.php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\AvocatInvitationNotification;

class AvocatController extends Controller
{
    public function index()
    {
        $avocats = auth()->user()->avocats()->withPivot('is_active', 'created_at')->get();

        return view('bailleur.avocats.index', compact('avocats'));
    }

    public function create()
    {
        $existingAvocats = User::query()->avocats()
            ->whereNotIn('id', auth()->user()->avocats->pluck('id'))
            ->get();

            // dd($existingAvocats);
        return view('bailleur.avocats.create', compact('existingAvocats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'avocat_id' => ['nullable', 'exists:users,id'],
            'name' => ['required_without:avocat_id', 'string', 'max:255'],
            'email' => ['required_without:avocat_id', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        if (!empty($validated['avocat_id'])) {
            // Associer un avocat existant
            $avocat = User::findOrFail($validated['avocat_id']);
        } else {
            // Vérifier si l'avocat existe déjà
            $avocat = User::where('email', $validated['email'])->first();

            if (!$avocat) {
                // Créer un nouveau compte avocat
                $temporaryPassword = Str::random(12);
                $avocat = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'password' => Hash::make($temporaryPassword),
                    'role' => 'avocat',
                ]);

                // Envoyer l'invitation par email
                $avocat->notify(new AvocatInvitationNotification(auth()->user(), $temporaryPassword));
            }
        }

        // Associer l'avocat au bailleur
        auth()->user()->avocats()->syncWithoutDetaching([
            $avocat->id => ['is_active' => true]
        ]);

        return redirect()->route('bailleur.avocats.index')
            ->with('success', 'Avocat associé avec succès.');
    }

    public function toggleStatus(User $avocat)
    {
        $pivot = auth()->user()->avocats()->where('avocat_id', $avocat->id)->first();

        if (!$pivot) {
            return back()->with('error', 'Cet avocat n\'est pas associé à votre compte.');
        }

        $newStatus = !$pivot->pivot->is_active;
        auth()->user()->avocats()->updateExistingPivot($avocat->id, ['is_active' => $newStatus]);

        $status = $newStatus ? 'activé' : 'désactivé';
        return back()->with('success', "Avocat {$status} avec succès.");
    }

    public function destroy(User $avocat)
    {
        auth()->user()->avocats()->detach($avocat->id);

        return redirect()->route('bailleur.avocats.index')
            ->with('success', 'Avocat dissocié avec succès.');
    }
}