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
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        .ticket {
            /*max-width: 300px;*/
        }

        .centered {
            margin: auto;
            text-align: center;
        }

        .line {
            border-bottom: 1px dashed black;
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="ticket">
    <h2 class="centered">{{ $store_name }}</h2>
    <p class="centered">{{ $address }}</p>
    <p>Date: {{ $date }}</p>
    <div class="line"></div>
    <table width="100%">
        <thead>
        <tr>
            <th width="70%"></th>
            <th width="15%"></th>
            <th width="15%"></th>
        </tr>
        </thead>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>x{{ $item['qty'] }}</td>
                <td style="text-align: right">{{ number_format($item['price'], 2) }}€</td>
            </tr>
        @endforeach
    </table>
    <div class="line"></div>
    <h3>Total: {{ number_format($total, 2) }}€</h3>
</div>
</body>
</html>
