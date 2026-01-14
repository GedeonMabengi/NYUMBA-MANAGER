<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu POS - {{ $payment->reference }}</title>
    <style>
        body {
            font-family: monospace;
            width: 320px; /* 80mm en pixels (1mm ≈ 4px) */
            margin: 0;
            padding: 5px;
            font-size: 12px;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 8px;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 1px dashed #000;
            margin-bottom: 3px;
        }
        .info-grid {
            display: flex;
            justify-content: space-between;
        }
        .info-box {
            width: 48%;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 2px 0;
        }
        .details-table td:first-child {
            width: 60%;
        }
        .amount-box {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }
        .amount {
            font-size: 18px;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .line {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }
        @media print {
            body {
                width: 320px;
                padding: 0;
                margin: 0;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REÇU DE PAIEMENT</h1>
        <p>Ref: {{ $payment->reference }}</p>
    </div>

    <div class="amount-box">
        <p>Montant reçu</p>
        <p class="amount">{{ $payment->formatted_amount }}</p>
        <p>Le {{ $payment->payment_date->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h2 class="section-title">Parties concernées</h2>
        <div class="info-grid">
            <div class="info-box">
                <p><strong>Bailleur:</strong></p>
                <p>{{ $payment->user->name }}</p>
                <p>{{ $payment->user->email }}</p>
                @if($payment->user->phone)
                    <p>{{ $payment->user->phone }}</p>
                @endif
            </div>
            <div class="info-box">
                <p><strong>Payeur:</strong></p>
                <p>{{ $payment->payer_name }}</p>
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
                <p><strong>Bien:</strong></p>
                <p>{{ $payment->rental->property->name }}</p>
                <p>{{ $payment->rental->property->address }}</p>
                <p>{{ $payment->rental->property->postal_code }} {{ $payment->rental->property->city }}</p>
            </div>
            <div class="info-box">
                <p><strong>Locataire:</strong></p>
                <p>{{ $payment->rental->tenant->first_name }} {{ $payment->rental->tenant->last_name }}</p>
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
                <td>Date:</td>
                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Méthode:</td>
                <td>
                    @php
                        $methods = [
                            'cash' => 'Espèces',
                            'bank_transfer' => 'Virement',
                            'check' => 'Chèque',
                            'card' => 'Carte',
                            'mobile_money' => 'Mobile Money',
                            'other' => 'Autre',
                        ];
                    @endphp
                    {{ $methods[$payment->payment_method] ?? 'Non spécifié' }}
                </td>
            </tr>
            <tr>
                <td>Loyer mensuel:</td>
                <td>{{ number_format($payment->rental->rent_amount, 2, ',', ' ') }} $</td>
            </tr>
            <tr>
                <td>Montant payé:</td>
                <td>{{ $payment->formatted_amount }}</td>
            </tr>
        </table>
    </div>

    @if($payment->notes)
        <div class="section">
            <h2 class="section-title">Notes</h2>
            <p>{{ $payment->notes }}</p>
        </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div class="line"></div>
            <p>Signature bailleur</p>
        </div>
        <div class="signature-box">
            <div class="line"></div>
            <p>Signature payeur</p>
        </div>
    </div>

    <div class="footer">
        <p>Reçu généré le {{ now()->format('d/m/Y H:i') }}</p>
        <p>Merci pour votre paiement !</p>
    </div>

    <button class="print-btn" onclick="window.print()" style="display: none;">
        Imprimer
    </button>
</body>
</html>
