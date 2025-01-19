<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Email</title>
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        h1, h2, h3 {
            color: #333;
            margin-bottom: 20px;
        }
        .shop-title{
            font-size: 32px;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    @php
    $country = country($maildata['order']->country_id) ;
    @endphp

    <h1 class="shop-title">Creto Bicyle Shop</h1>
    <h1>{{ $maildata['subject'] }}</h1>
    <h2>Your Order id is: #{{ $maildata['order']->id }}</h2>

    <h5>Shipping Address</h5>
    <address>
        <strong>{{$maildata['order']->first_name}} {{$maildata['order']->last_name}}</strong><br>
        {{ $maildata['order']->address }}<br>
        {{ $maildata['order']->state }}, {{ $maildata['order']->zip }} {{ $country->name }} <br>
        Phone: {{ $maildata['order']->mobile }}<br>
        Email: {{ $maildata['order']->email }}
    </address>

    <h3>Products</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th width="100">Price</th>
                <th width="100">Qty</th>
                <th width="100">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maildata['order']->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>${{ number_format($item->price,2) }}</td>
                <td>{{ $item->qty }}</td>
                <td>${{ number_format($item->total,2) }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3" class="text-right">Subtotal:</th>
                <td>${{ number_format($maildata['order']->subtotal,2)}}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Discount {{ ($maildata['order']->coupon_code != null) ? '('. $maildata['order']->coupon_code .')' : '' }}:</th>
                <td>${{ number_format($maildata['order']->discount,2)}}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Shipping:</th>
                <td>${{ number_format($maildata['order']->shipping,2)}}</td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Grand Total:</th>
                <td>${{ number_format($maildata['order']->grand_total,2)}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
