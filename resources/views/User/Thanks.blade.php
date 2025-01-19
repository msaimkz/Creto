<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creto</title>
    <link rel="stylesheet" href="{{asset('asset/user/style.css')}}">
</head>

<body>

    <div class="Thanks-container">
        <div class="Thanks-content">
            <h1>Thanks For Shopping!</h1>
            <h2>Your Order Placed Successfully</h2>
            <h3>Your Order is #{{ $orderId}}</h3>
            <a href="{{ route('index') }}">
                <span>
                    Home
                </span>
            </a>
        </div>
    </div>

</body>

</html>