

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .background {
            background-image: url('img/BG.png');
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
    border: 1px solid #000; /* Added border */
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

      
        .forgot-password {
            margin-top: 1rem;
        }

        header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <header class="d-flex align-items-center justify-content-between p-2 bg-light border-bottom">
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/registrar.png') }}" alt="Logo" class="me-3 pe-3 border-end" style="height: 50px;">
        </div>
        <div class="d-flex align-items-between justify-content-between  w-100">
            <div class="d-flex align-items-center justify-content-center">
                <h5>Office of the University Registrar</h5>
            </div>
            <div class="me-3">
                <div class="">
                    <h5>University of Southeastern Philippines</h5>
                </div>
                <div class="text-end">
                    <h5>Enrollment Report System</h5>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center">

            <div class=" border-start ">
                <a class=" d-flex align-items-center ">
                    <img class="ms-3" style="height: 50px;" src="{{ asset('img/usep.png') }}">
                </a>

            </div>
        </div>
    </header>
    <div class="background">

        <div class="secondary-background"></div>
        <div class="login-form">
            <h1>Log In</h1>
            @include('layouts._message')
            <form method="post" action="{{ url('login') }}" >
            @csrf
                <label>Username:</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" required>
                </div>
                <label>Password:</label>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn w-100 rounded-pill" style="background-color: #fabd7f;">Confirm</button>
            </form>
            <div class="forgot-password">
                <a href="#">Forgot Password? <span class="text-primary">Click here</span></a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>