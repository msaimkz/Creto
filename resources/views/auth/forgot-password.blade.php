
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="{{ asset('asset/Form/fonts/linearicons/style.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/Form/css/style.css') }}">



</head>

<body>
<x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="wrapper">
        <div class="inner">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <p class="forget-password">
                    Forgot your password? No problem. Just let us know your email address and we will email you a
                    password reset link that will allow you to choose a new one.
                </p>
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input class="form-controls" id="email" type="email" name="email" :value="old('email')" required
                    autofocus placeholder="Email">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('email')) }}</p>
                <button>
                    <span>Email Password Reset Link</span>
                </button>
            </form>

        </div>

    </div>
</body>

</html>