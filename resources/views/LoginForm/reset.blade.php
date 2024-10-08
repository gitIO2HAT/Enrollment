<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('img/registrar.png') }}" rel="icon">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .background {
         
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 95vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            z-index: 1;
        }

        .login-form h1 {
            margin-bottom: 1.5rem;
        }

        .login-form .form-control {
            border: 1px solid #000;
            border-radius: 30px;
            margin-bottom: 1rem;
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .vertical-line {
            width: 2px;
            height: 80px;
            background-color: #000;
        }

        .forgot-password {
            margin-top: 1rem;
        }

        .btn-forget {
            background-color: #a00000;
            color: white;
            font-weight: bold;
            padding: 0.75rem;
            border-radius: 20px;
            border: none;
        }

        .btn-forget:hover {
            background-color: #800000;
        }

    </style>
</head>

<body>
    <div class="background">
        <div class="login-form">
            <!-- Logo Section -->
            <div class="logo-section">
                <img src="{{ asset('img/usep.png') }}" alt="University Logo" style="width: 80px; height: 80px;">
                <div class="vertical-line"></div>
                <img src="{{ asset('img/registrar.png') }}" alt="Registrar Logo" style="width: 80px; height: 80px;">
            </div>

            <!-- Title -->
            <h1>Reset Password</h1>

            <!-- Message Include -->
            @include('layouts._message')
            @if (Session::has('status'))
                <div class="alert alert-success">{{ Session::get('status') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <!-- Form -->
            <form method="post" action="{{ url('/password/reset') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                  <label>Email:</label>
                <div class="mb-3">
                    <input type="email" id="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus style="width: 200px; margin: 0 auto;">
                </div>
                
                <label>New Password:</label>
                <div class="mb-3">
                    <input id="password" type="password" class="form-control" name="password" required onkeyup="checkPasswordMatch();" style="width: 200px; margin: 0 auto;">
                </div>
                <label>Confirm Password:</label>
                <div class="mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required onkeyup="checkPasswordMatch();" style="width: 200px; margin: 0 auto;">
                </div>
                <div id="passwordMatchMessage" style="color:black; text-align:center; margin-top:10px;"></div>
                <button type="submit" class="btn  rounded-pill" style="background-color: #fabd7f; width: 200px; margin: 0 auto;" >Confirm</button>
            </form>
            <div class="forgot-password">
                <a href="\">Log In? <span class="text-primary"><b>Click here</b></span></a>
            </div>
               

                

           
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


