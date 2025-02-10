<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link rel="stylesheet" href="{{ asset('asset/Form/fonts/linearicons/style.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/Form/css/style.css') }}">



</head>

<body>
    <div class="wrapper">
        <div class="inner">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <h3 class="email-verify-head">Email Verification</h3>
                <p class="verify-email-para">Thanks for signing up! Before getting started, could you verify your email
                    address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will
                    gladly
                    send you another.</p>
                <button type="submit">
                    <span>Send Verification Email</span>
                </button>
            </form>

        </div>

    </div>
</body>

</html>
