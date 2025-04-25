<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Struck</title>

    <style>
        body {
            font-weight: bold;
            font-size: 12px;
            font-family: Arial, sans-serif;
            text-align: center;

        }

        .wrapper {
            border: 1px solid black;
            text-align: center;
        }

        .divider {
            border-bottom: 1px solid black;
        }

        .item-row {
            margin-bottom: 10px;
            text-align: left;

        }

        .item-row .left {
            margin: 10px;
            text-align: left;
        }



        .item-row .right {
            margin: 10px;
            text-align: right;
        }

        .date {
            margin: 10px;
        }

        .transaksi {
            margin: 10px;
        }
    </style>
</head>

<body onload='window.print()'>
    <div class="wrapper">
        <header>
            <h1>MineStore</h1>
            <p>Jl.jalaninajadulu, RT/RW 09/19, Jakarta Tengah</p>
            <p>No.Telp 0812-1961-8557</p>
        </header>
        <div class="divider"></div>
        <div>
            <div class='date'>Tanggal : {{ date('d M Y', strtotime($orders->order_date)) }}</div>
            <div class='transaksi'>No Transaksi : {{ $orders->order_code }}</div>
        </div>
        <div class="divider"></div>
        @foreach ($orderDetails as $orderDetail)
            <div class="item-row">
                <div class="left">Nama: <br>{{ $orderDetail->product->product_name ?? '' }}</div>

            </div>
            <div class="item-row">
                <div class="left">Jumlah :<br>{{ $orderDetail->qty }} x
                    {{ number_format($orderDetail->order_price) }}<br>
                </div>
                <div class="right">{{ number_format($orderDetail->order_subtotal) ?? '' }}</div>
            </div>
        @endforeach
        <div class="item-row">
            <div class="left"></div>
            <div class="right">Total : <br>{{ number_format($orderDetail->order->order_amount) }}</div>
        </div>

        <div class="item-row"></div>
    </div>

</body>

</html>
