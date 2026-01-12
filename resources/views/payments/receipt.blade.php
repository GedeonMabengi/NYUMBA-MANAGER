{{-- resources/views/payments/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - {{ $payment->reference }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #16a34a;
            font-size: 24px;
            margin: 0 0 5px 0;
        }
        
        .reference-box {
            background: #f0fdf4;
            border: 1px solid #16a34a;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .reference-box .label {
            font-size: 10px;
            color: #666;
        }
        
        .reference-box .value {
            font-size: 18px;
            font-weight: bold;
            color: #16a34a;
        }
        
        .amount-box {
            background: #16a34a;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .amount-box .amount {
            font-size: 32px;
            font-weight: bold;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px;
            vertical-align: top;
        }
        
        .info-box {
            background: #f9fafb;
            padding: 10px;
        }
        
        .info-box h3 {
            font-size: 10px;
            color: #888;
            margin: 0 0 5px 0;
        }
        
        .info-box p {
            margin: 2px 0;
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .details-table td:last-child {
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
            font-size: 10px;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }
        
        .signature-table {
            width: 100%;
            margin-top: 40px;
        }
        
        .signature-table td {
            width: 50%;
            text-align: center;
            padding-top: 40px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin: 0 20px;
            padding-top: 5px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REÇU DE PAIEMENT</h1>
        <p>Document officiel</p>
    </div>

    <div class="reference-box">
        <p class="label">Numéro de référence</p>
        <p class="value">{{ $payment->reference }}</p>
    </div>

    <div class="amount-box">
        <p>Montant reçu</p>
        <p class="amount">{{ $payment->formatted_amount }}</p>
        <p>Le {{ $payment->payment_date->format('d F Y') }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Parties concernées</h2>
        <table class="info-table">
            <tr>
                <td width="50%">
                    <div class="info-box">
                        <h3>BAILLEUR</h3>
                        <p><strong>{{ $payment->user->name }}</strong></p>
                        <p>{{ $payment->user->email }}</p>
                    </div>
                </td>
                <td width="50%">
                    <div class="info-box">
                        <h3>PAYEUR</h3>
                        <p><strong>{{ $payment->payer_name }}</strong></p>
                        @if($payment->payer_phone)<p>{{ $payment->payer_phone }}</p>@endif
                        @if($payment->payer_email)<p>{{ $payment->payer_email }}</p>@endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2 class="section-title">Bien et Location</h2>
        <table class="info-table">
            <tr>
                <td width="50%">
                    <div class="info-box">
                        <h3>BIEN IMMOBILIER</h3>
                        <p><strong>{{ $payment->rental->property->name }}</strong></p>
                        <p>{{ $payment->rental->property->address }}</p>
                        <p>{{ $payment->rental->property->postal_code }} {{ $payment->rental->property->city }}</p>
                    </div>
                </td>
                <td width="50%">
                    <div class="info-box">
                        <h3>LOCATAIRE</h3>
                        <p><strong>{{ $payment->rental->tenant->first_name }} {{ $payment->rental->tenant->last_name }}</strong></p>
                        <p>{{ $payment->rental->tenant->phone }}</p>
                    </div>
                </td>
            </tr>
        </table>
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
                <td>Montant payé</td>
                <td style="color: #16a34a;">{{ $payment->formatted_amount }}</td>
            </tr>
        </table>
    </div>

    @if($payment->notes)
        <div class="section">
            <h2 class="section-title">Notes</h2>
            <p>{{ $payment->notes }}</p>
        </div>
    @endif

    <table class="signature-table">
        <tr>
            <td>
                <div class="signature-line">Signature du bailleur</div>
            </td>
            <td>
                <div class="signature-line">Signature du payeur</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Ce reçu a été généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>Document valable sans signature pour les paiements électroniques</p>
    </div>
</body>
</html>