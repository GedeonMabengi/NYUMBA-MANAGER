{{-- resources/views/payments/receipt-print.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement - {{ $payment->reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #16a34a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #16a34a;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .reference {
            background: #f0fdf4;
            border: 1px solid #16a34a;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .reference .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        
        .reference .value {
            font-size: 24px;
            font-weight: bold;
            color: #16a34a;
            font-family: monospace;
        }
        
        .amount-box {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .amount-box .label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .amount-box .amount {
            font-size: 48px;
            font-weight: bold;
        }
        
        .amount-box .date {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 10px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .info-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px;
        }
        
        .info-box h3 {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 5px;
        }
        
        .info-box p {
            color: #333;
            font-size: 14px;
        }
        
        .info-box p.main {
            font-weight: bold;
            font-size: 16px;
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .details-table td {
            padding: 10px 0;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .details-table td:first-child {
            color: #666;
            width: 40%;
        }
        
        .details-table td:last-child {
            font-weight: 500;
            text-align: right;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px dashed #e5e5e5;
            text-align: center;
            color: #888;
            font-size: 12px;
        }
        
        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 50px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-box .line {
            border-bottom: 1px solid #333;
            height: 60px;
            margin-bottom: 10px;
        }
        
        .signature-box .label {
            font-size: 12px;
            color: #666;
        }
        
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #16a34a;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .print-btn:hover {
            background: #15803d;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .receipt {
                box-shadow: none;
                padding: 20px;
            }
            
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>REÇU DE PAIEMENT</h1>
            <p class="subtitle">Document officiel</p>
        </div>

        <div class="reference">
            <p class="label">Numéro de référence</p>
            <p class="value">{{ $payment->reference }}</p>
        </div>

        <div class="amount-box">
            <p class="label">Montant reçu</p>
            <p class="amount">{{ $payment->formatted_amount }}</p>
            <p class="date">Le {{ $payment->payment_date->format('d F Y') }}</p>
        </div>

        <div class="section">
            <h2 class="section-title">Parties concernées</h2>
            <div class="info-grid">
                <div class="info-box">
                    <h3>Bailleur (reçoit le paiement)</h3>
                    <p class="main">{{ $payment->user->name }}</p>
                    <p>{{ $payment->user->email }}</p>
                    @if($payment->user->phone)
                        <p>{{ $payment->user->phone }}</p>
                    @endif
                </div>
                <div class="info-box">
                    <h3>Payeur</h3>
                    <p class="main">{{ $payment->payer_name }}</p>
                    @if($payment->payer_phone)
                        <p>{{ $payment->payer_phone }}</p>
                    @endif
                    @if($payment->payer_email)
                        <p>{{ $payment->payer_email }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Bien et Location</h2>
            <div class="info-grid">
                <div class="info-box">
                    <h3>Bien immobilier</h3>
                    <p class="main">{{ $payment->rental->property->name }}</p>
                    <p>{{ $payment->rental->property->address }}</p>
                    <p>{{ $payment->rental->property->postal_code }} {{ $payment->rental->property->city }}</p>
                </div>
                <div class="info-box">
                    <h3>Locataire</h3>
                    <p class="main">{{ $payment->rental->tenant->first_name }} {{ $payment->rental->tenant->last_name }}</p>
                    <p>{{ $payment->rental->tenant->phone }}</p>
                    @if($payment->rental->tenant->email)
                        <p>{{ $payment->rental->tenant->email }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Détails du paiement</h2>
            <table class="details-table">
                <tr>
                    <td>Date du paiement</td>
                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Méthode de paiement</td>
                    <td>
                        @php
                            $methods = [
                                'cash' => 'Espèces',
                                'bank_transfer' => 'Virement bancaire',
                                'check' => 'Chèque',
                                'card' => 'Carte bancaire',
                                'mobile_money' => 'Mobile Money',
                                'other' => 'Autre',
                            ];
                        @endphp
                        {{ $methods[$payment->payment_method] ?? 'Non spécifié' }}
                    </td>
                </tr>
                <tr>
                    <td>Loyer mensuel</td>
                    <td>{{ number_format($payment->rental->rent_amount, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td>Montant payé</td>
                    <td style="color: #16a34a; font-weight: bold;">{{ $payment->formatted_amount }}</td>
                </tr>
            </table>
        </div>

        @if($payment->notes)
            <div class="section">
                <h2 class="section-title">Notes</h2>
                <p style="color: #666; font-style: italic;">{{ $payment->notes }}</p>
            </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div class="line"></div>
                <p class="label">Signature du bailleur</p>
            </div>
            <div class="signature-box">
                <div class="line"></div>
                <p class="label">Signature du payeur</p>
            </div>
        </div>

        <div class="footer">
            <p>Ce reçu a été généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Document valable sans signature pour les paiements électroniques</p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        🖨️ Imprimer
    </button>
</body>
</html>