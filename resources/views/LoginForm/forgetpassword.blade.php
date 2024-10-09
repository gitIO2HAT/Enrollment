<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('img/registrar.png') }}" rel="icon">
    <title>Forget Password</title>
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
    width: 0.5px;
    height: 20px; /* Adjust the height to match the logos */
    background-color: rgb(203, 203, 203); /* Line color (black in this case) */
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
        </p>
            <!-- Title -->
            <h4>Forget Password</h4>

            <!-- Message Include -->
            @include('layouts._message')
            @if (Session::has('status'))
                <div class="alert alert-success">{{ Session::get('status') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            <!-- Form -->
            @include('layouts._message')
            <form method="post" action="{{ url('/ForgetPassword/Reset') }}">
                @csrf
                <label><b>Email</b>:</label>
                <div class="mb-3">
                    <input type="email" placeholder="Ex. example@usep.edu.ph" class="form-control" name="email" required style="width: 200px; margin: 0 auto;">
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <label for="questions" class="form-label"><b>Security Question</b>:</label>
                <div class="mb-3">
                    <select id="questions" class="form-control" name="questions" required style="width: 200px; margin: 0 auto;">
                        <option selected disabled>--Select Question--</option>
                        <option value="1">Mother's Maiden Name?</option>
                        <option value="2">First Pet's Name?</option>
                        <option value="3">City You Were Born In?</option>
                        <option value="4">Name of Your Favorite Teacher?</option>
                        <option value="5">Model of Your First Car?</option>
                        <option value="6">Title of Your Favorite Book?</option>
                        <option value="7">Name of Your First School?</option>
                        <option value="8">Title of Your Favorite Movie?</option>
                        <option value="9">Your Favorite Color?</option>
                        <option value="10">Name of Your Best Friend in Childhood?</option>
                    </select>
                    @if($errors->has('questions'))
                        <span class="text-danger">{{ $errors->first('questions') }}</span>
                    @endif
                </div>

                <label><b>Answer</b>:</label>
                <div class="mb-3">
                    <input type="password" class="form-control" name="answer" required style="width: 200px; margin: 0 auto;">
                    @if($errors->has('answer'))
                        <span class="text-danger">{{ $errors->first('answer') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn-forget" style="width: 200px; margin: 0 auto;">Forget</button >
            </form>

            <!-- Forgot Password -->
            <div class="forgot-password">
                <a href="{{ url('/') }}">Remembered your password? <span class="text-primary"><b>Click here</b></span></a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
