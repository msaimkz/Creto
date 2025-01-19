<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('asset/Form/fonts/linearicons/style.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/Form/css/style.css') }}">
   


</head>

<body>
<a href="{{ route('login') }}" class="auth-anchor">Log in</a>
    <div class="wrapper">
        <div class="inner">
            <form method="POST" action="{{ route('store-register') }}">
                @csrf
                <h3>Register</h3>
                <div class="form-holder">
                    <span class="lnr lnr-user"></span>
                    <input type="text" class="form-controls" id="name" placeholder="Username" name="name"
                        value="{{ old('name') }}"  autofocus autocomplete="name">
                </div>
                <p class="invalid-feedback" style="color: red">{{ implode(', ', $errors->get('name')) }}</p>
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input class="form-controls" placeholder="Email" id="email" type="email" name="email"
                        value="{{old('email')}}"  autocomplete="username">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('email')) }}</p>

                <div class="form-holder">
                    <span class="lnr lnr-phone"></span>
                    <input class="form-controls" placeholder="Phone" id="mobile" type="text" name="mobile"
                        value="{{old('mobile')}}"  autocomplete="username">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('mobile')) }}</p>

               

                

                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input class="form-controls" placeholder="Password" id="password" type="password" name="password"
                         autocomplete="new-password">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('password')) }}</p>

                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input class="form-controls" placeholder="Confirm Password" id="password_confirmation"
                        type="password" name="password_confirmation"  autocomplete="new-password">
                </div>
                <p class="invalid-feedback">{{ implode(', ', $errors->get('password_confirmation')) }}</p>

                <button>
                    <span>Register</span>
                </button>
            </form>

        </div>

    </div>
</body>

</html>