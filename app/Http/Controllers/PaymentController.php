<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'bailleur') {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    /**
     * Affiche la liste des paiements du bailleur
     */
    public function index(Request $request): View
    {
        $query = Payment::with(['rental.property', 'rental.tenant'])
            ->forBailleur(auth()->id())
            ->latest('payment_date');

        // Filtres
        if ($request->filled('rental_id')) {
            $query->where('rental_id', $request->rental_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payer_name', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $payments = $query->paginate(15)->withQueryString();

        // Récupérer les locations actives pour le filtre
        $rentals = Rental::with(['property', 'tenant'])
            ->whereHas('property', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'active')
            ->get();

        // Statistiques
        $stats = [
            'total_amount' => Payment::forBailleur(auth()->id())->confirmed()->sum('amount'),
            'this_month' => Payment::forBailleur(auth()->id())
                ->confirmed()
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
            'count' => Payment::forBailleur(auth()->id())->confirmed()->count(),
        ];

        return view('payments.index', compact('payments', 'rentals', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create(Request $request): View
    {
        $rentals = Rental::with(['property', 'tenant'])
            ->whereHas('property', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'active')
            ->get();

        $selectedRental = null;
        if ($request->filled('rental_id')) {
            $selectedRental = $rentals->find($request->rental_id);
        }

        $paymentMethods = [
            'cash' => 'Espèces',
            'bank_transfer' => 'Virement bancaire',
            'check' => 'Chèque',
            'card' => 'Carte bancaire',
            'mobile_money' => 'Mobile Money',
            'other' => 'Autre',
        ];

        return view('payments.create', compact('rentals', 'selectedRental', 'paymentMethods'));
    }

    /**
     * Enregistre un nouveau paiement
     */
    public function store(StorePaymentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['reference'] = Payment::generateReference();
        $data['status'] = 'confirmed';

        $payment = Payment::create($data);

        // Log de l'activité
        $this->logActivity('created', $payment);

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Le paiement a été enregistré avec succès. Référence: ' . $payment->reference);
    }

    /**
     * Affiche les détails d'un paiement
     */
    public function show(Payment $payment): View
    {
        $this->authorize('view', $payment);

        $payment->load(['rental.property.propertyType', 'rental.tenant', 'user']);

        return view('payments.show', compact('payment'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Payment $payment): View
    {
        $this->authorize('update', $payment);

        $payment->load(['rental.property', 'rental.tenant']);

        $paymentMethods = [
            'cash' => 'Espèces',
            'bank_transfer' => 'Virement bancaire',
            'check' => 'Chèque',
            'card' => 'Carte bancaire',
            'mobile_money' => 'Mobile Money',
            'other' => 'Autre',
        ];

        return view('payments.edit', compact('payment', 'paymentMethods'));
    }

    /**
     * Met à jour un paiement
     */
    public function update(UpdatePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $this->authorize('update', $payment);

        $oldValues = $payment->toArray();
        
        $payment->update($request->validated());

        // Log de l'activité
        $this->logActivity('updated', $payment, $oldValues);

        return redirect()
            ->route('payments.show', $payment)
            ->with('success', 'Le paiement a été mis à jour avec succès.');
    }

    /**
     * Supprime un paiement
     */
    public function destroy(Payment $payment): RedirectResponse
    {
        $this->authorize('delete', $payment);

        $oldValues = $payment->toArray();
        
        $payment->delete();

        // Log de l'activité
        $this->logActivity('deleted', $payment, $oldValues);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Le paiement a été supprimé avec succès.');
    }

    /**
     * Génère un reçu PDF
     */
    public function receipt(Payment $payment)
    {
        $this->authorize('view', $payment);

        $payment->load(['rental.property.propertyType', 'rental.tenant', 'user']);

        $pdf = Pdf::loadView('payments.receipt', compact('payment'));
        
        return $pdf->download('recu-paiement-' . $payment->reference . '.pdf');
    }

    /**
     * Affiche le reçu en HTML (pour impression)
     */
    public function printReceipt(Payment $payment): View
    {
        $this->authorize('view', $payment);

        $payment->load(['rental.property.propertyType', 'rental.tenant', 'user']);

        return view('payments.receipt-print', compact('payment'));
    }

    /**
     * Exporte les paiements en CSV
     */
    public function export(Request $request)
    {
        $query = Payment::with(['rental.property', 'rental.tenant'])
            ->forBailleur(auth()->id())
            ->confirmed()
            ->latest('payment_date');

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->get();

        $filename = 'paiements-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            
            // BOM pour Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // En-têtes
            fputcsv($file, [
                'Référence',
                'Date',
                'Bien',
                'Locataire',
                'Payeur',
                'Montant',
                'Méthode',
                'Statut'
            ], ';');

            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->reference,
                    $payment->payment_date->format('d/m/Y'),
                    $payment->rental->property->name ?? '-',
                    $payment->rental->tenant->first_name . ' ' . $payment->rental->tenant->last_name,
                    $payment->payer_name,
                    number_format($payment->amount, 2, ',', ' '),
                    $payment->payment_method ?? '-',
                    $payment->status
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Enregistre l'activité
     */
    protected function logActivity(string $action, Payment $payment, array $oldValues = null): void
    {
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => Payment::class,
            'model_id' => $payment->id,
            'old_values' => $oldValues,
            'new_values' => $action !== 'deleted' ? $payment->toArray() : null,
            'ip_address' => request()->ip(),
        ]);
    }
}