

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('asset/Form/fonts/linearicons/style.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/Form/css/style.css') }}">



</head>

<body>
    <div class="wrapper">
        <div class="inner">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input class="form-controls" id="email" class="block mt-1 w-full" type="email" name="email"
                        value="{{old('email', $request->email)}}" required autofocus autocomplete="username" placeholder="Email">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('email')) }}</p>

                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input class="form-controls" id="password" class="block mt-1 w-full" type="password" name="password"
                        required autocomplete="new-password" placeholder="Password">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('password')) }}</p>

                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input class="form-controls" id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('password_confirmation')) }}</p>

                <button>
                    <span>Reset Password</span>
                </button>
            </form>

        </div>

    </div>
</body>

</html>