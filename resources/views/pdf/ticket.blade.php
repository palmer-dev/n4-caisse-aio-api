<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Caisse</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 5px 10px 0 10px;
        }

        body {
            margin: 0px;
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        .ticket {
            margin: auto;
        }

        .centered {
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
        }

        .line {
            border-bottom: 1px dashed black;
            margin: 5px 0;
        }

        table {
            width: 100%;
        }

        th, td {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        p, h3 {
            margin: 0;
            word-wrap: break-word;
            white-space: normal;
            margin-bottom: 5px;
        }

        p.no-margin {
            margin-bottom: 0;
        }

        .small {
            font-size: 6px;
        }
    </style>
</head>
<body>
<div class="ticket">
    <h2 class="centered">{{ $store_name }}</h2>
    <p class="centered">{{ $address }}</p>
    <p class="centered">SIRET : {{ $siret }} | RCS : {{ $rcs }}</p>
    <p>Date : {{ $date }} - Heure : {{ $time }}</p>
    <p>Ticket n° : {{ $sale_no }}</p>

    <div class="line"></div>

    <table>
        <thead>
        <tr>
            <th>Article</th>
            <th>Qté</th>
            <th class="right">Prix</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>x{{ $item['qty'] }}</td>
                <td class="right">{{ $item['price'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table>
        <tbody>
        <tr>
            <td>Total HT</td>
            <td class="right">{{ $total_ht }}</td>
        </tr>
        @foreach($tax_breakdown as $taxRate => $taxAmount)
            <tr>
                <td>TVA ({{ $taxRate }}%)</td>
                <td class="right">{{ $taxAmount }}</td>
            </tr>
        @endforeach
        @if($has_discount)
            <tr>
                <td>Remise TTC appliquée</td>
                <td class="right">-{{ $discount }}</td>
            </tr>
        @endif
        <tr>
            <th>Total TTC</th>
            <th class="right">{{ $total }}</th>
        </tr>
        <tr>
            <td>Mode de paiement</td>
            <td class="right">{{ $payment_method }}</td>
        </tr>
        @if($tva_exempt)
            <tr>
                <td colspan="2">TVA non applicable – art. 293 B du CGI</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="line"></div>
    <p class="centered no-margin">Merci de votre visite !</p>
    <br>
    <p class="centered small no-margin">Powered by Eco-Caisse</p>
</div>
</body>
</html>
