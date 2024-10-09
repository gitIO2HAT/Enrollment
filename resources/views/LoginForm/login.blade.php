<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('img/registrar.png') }}" rel="icon">
    <title>Enrollment and Graduate Report System</title>
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
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-form {
            background: white;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-form h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .login-form img {
            width: 80px;
            height: 80px;
        }

        .login-form .form-control {
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-bottom: 1rem;
            padding: 0.75rem;
        }

        .login-form button {
            background-color: #a00000;
            color: white;
            font-weight: bold;
            padding: 0.75rem;
            border-radius: 20px;
            border: none;
        }

        .login-form .forgot-password {
            margin-top: 1rem;
        }

        .login-form a {
            color: #007bff;
            text-decoration: none;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        .logo-section {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px; /* Space between logos and line */
}

.vertical-line {
    width: 0.5px;
    height: 20px; /* Adjust the height to match the logos */
    background-color: rgb(203, 203, 203); /* Line color (black in this case) */
}


        .login-title {
            font-weight: bold;
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

    </style>
</head>

<body>
    <div class="background">
        <div class="login-form">
            <!-- Logo Section -->
            <div class="logo-section">
    <img src="{{ asset('img/usep.png') }}" alt="University Logo">

    <!-- Vertical Line -->
    <div class="vertical-line"></div>

    <img src="{{ asset('img/registrar.png') }}" alt="Secondary Logo">
</div>
</p>
            <!-- Title -->
            <div class="login-title">Enrollment and Graduate Report System</div>
            <!-- Login Form -->
            @include('layouts._message')
            <form method="post" action="{{ url('login') }}">

                @csrf
                <div style="text-align: center;">
                <label><b>Username</b></label>
    <input type="text" class="form-control" name="username" placeholder="enter your username" required style="width: 200px; margin: 0 auto;">
</div>
<div style="text-align: center; margin-top: 20px;">
<label><b>Password</b></label>
    <input type="password" class="form-control" name="password" placeholder="enter your password" required style="width: 200px; margin: 0 auto;">
</div>

<div style="text-align: center; margin-top: 20px;">
<button type="submit" class="btn"  style="width: 200px; margin: 0 auto;">Log-in</button>
</div>



            </form>
            <!-- Forgot Password -->
            <div class="forgot-password">
                <a href="{{ url('/ForgetPassword') }}">Forgot password? <span class="text-primary"><b>Click here</b></span></a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
