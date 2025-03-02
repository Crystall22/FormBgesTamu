<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Formulir Web Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #30466e, #2A5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Container holding the form */
        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
            padding: 40px;
            user-select: none;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2A5298;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
        }

        .text-center a {
            color: #2A5298;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Desktop view - logo outside the form box, original size */
        @media (min-width: 769px) {
            .login-wrapper {
                flex-direction: row;
                max-width: 900px;
            }

            .login-logo-container {
                margin-right: 40px;
            }

            .logo-img {
                max-width: 400px; /* Retain original larger size */
                transition: transform 0.3s ease, opacity 0.3s ease;
            }

            .logo-img:hover {
                content: url("{{ asset('images/telkom.png') }}");
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Mobile view - logo inside the form container, reduced size */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-logo-container img {
                max-width: 100px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Wrapper for Logo and Form -->
    <div class="login-wrapper">
        <!-- Logo Container (outside the form container on desktop, top inside the container on mobile) -->
        <div class="login-logo-container">
            <img src="{{ asset('images/telkom2.png') }}" alt="Telkom" class="logo-img">
        </div>

        <!-- Login Form Container -->
        <div class="login-container">
            <h2>Login</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
