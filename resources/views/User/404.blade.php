<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creto</title>
    <link rel="stylesheet" href="{{asset('asset/user/style.css')}}">
</head>

<body>

    <div class="error-container">
        <div class="error-content">
            <h1>OOPS!</h1>
            <h2>Not Found</h2>
            <h3>Don't worry let's go Home</h3>
            <a href="{{ route('index') }}">
                <span>
                    Home
                </span>
            </a>
        </div>
    </div>

</body>

</html>