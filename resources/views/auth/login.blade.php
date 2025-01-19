
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('asset/Form/fonts/linearicons/style.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/Form/css/style.css') }}">



</head>

<body>
    <a href="{{ route('register') }}" class="auth-anchor">Regiester</a>
    <div class="wrapper">
        <div class="inner">
            <form method="POST" action="{{ route('store-login') }}">
                @csrf
                <h3>Login</h3>
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input class="form-controls" id="email" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" placeholder="Email">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('email')) }}</p>

                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input class="form-controls" id="password" type="password" name="password"
                        required autocomplete="current-password" placeholder="Password">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('password')) }}</p>
                <div class="form-holders">
                    <div>
                        <input id="remember_me" class="form-control" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}">Forget your password</a>
                    </div>
                </div>
                <button>
                    <span>Log in</span>
                </button>
            </form>

        </div>

    </div>
</body>

</html>