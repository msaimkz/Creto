<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe Email</title>
    <link rel="stylesheet" href="{{asset('asset/user/style.css')}}">

    <style>
        .Subscribe-email-container {
            display: flex;
            flex-direction: column;
            gap: 50px;
            padding: 30px;
        }

        .Subscribe-email-container h1 {
            font-family: "Teko", sans-serif;
            font-size: 50px;
            color: #ffdb1d;
            font-weight: bold;
            text-align: center;
        }

        .Subscribe-email-container .discount {
            font-family: "Teko", sans-serif;
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            color: #000;
        }

        .Subscribe-email-container p {
            font-size: 22px;
            text-align: center;
            font-family: "Roboto Condensed", sans-serif;
            font-weight: 300;
        }

        .Subscribe-email-container h2 {
            font-family: "Teko", sans-serif;
            font-size: 40px;
            font-weight: bold;
            text-align: center;
        }

        .Subscribe-email-container h3 {
            font-family: "Teko", sans-serif;
            font-size: 27px;
            font-weight: bold;
            text-align: center;
        }
    </style>

</head>

<body>


    <div class="Subscribe-email-container">

        <div>
            <h1>{{$maildata['coupon']->name}}</h1>
        </div>

        <div>
            <h1 class="discount">
                Get
                @if($maildata['coupon']->type == 'percent')
                {{ $maildata['coupon']->discount_amount }}%
                @else
                ${{ $maildata['coupon']->discount_amount }}
                @endif

                Discount For Shopping
            </h1>
        </div>

        <div>
            <p>{{$maildata['coupon']->description}}</p>
        </div>
        <div>
            <h2>Coupon Code</h2>
            <h3>{{$maildata['coupon']->code}}</h3>
        </div>

    </div>

</body>

</html>