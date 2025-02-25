<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Formulir Web Tamu')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #cfc5df;
                color: #333;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 960px;
                margin: 30px auto;
                padding: 20px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1{
                font-size: 2.1rem;
                color: #4d4d4d;
                font-weight: bold;
                margin-bottom: 20px;
            }

            h2{
                font-size: 2.1rem;
                color: #000000;
                font-weight: bold;
                margin-bottom: 20px;
            }

            p2{
                font-size: 2.7rem;
                color: #4d4d4d;
                font-weight: bold;
                margin-bottom: 20px;
            }


            .form-control {
                margin-bottom: 15px;
                border-radius: 8px;
                padding: 12px;
            }

            .btn {
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: bold;
            }

            .btn-primary {
                background-color: #325bcc;
                border-color: #325bcc;
                color: #fff;
                transition: background-color 0.3s;
            }

            .btn-primary:hover {
                background-color: #2b4bb2;
            }

            .btn-secondary {
                background-color: #325bcc;
                border-color: #325bcc;
                color: #fff;
                transition: background-color 0.3s;
            }

            .btn-secondary:hover {
                background-color: #2b4bb2;
            }

            .card {
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                margin-bottom: 20px;
            }

            .card-title {
                font-size: 1.5rem;
                color: #325bcc;
                font-weight: 600;
                margin-bottom: 15px;
            }

            .banner {
                background-color: #ffffff;
                color: white;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-sizing: border-box;
                border-bottom: 4px solid #ffffff;
                flex-wrap: wrap;
            }

            .banner-content {
                flex: 1;
                min-width: 250px;
            }

            .banner-content h1 {
                font-size: 1.5rem;
                margin-bottom: 5px;
                font-weight: bold;
                line-height: 1.2;
            }

            .banner-content p {
                margin: 0;
                font-size: 1.0rem;
                color: #000000;
            }

            .logo-container {
                display: flex;
                align-items: center;
                gap: 15px;
                justify-content: flex-end;
            }

            .logo-container img {
                max-height: 70px;
                height: auto;
                width: auto;
            }

            @media (max-width: 768px) {
                .banner {
                    flex-direction: column;
                    text-align: center;
                }

                .banner-content h1 {
                    font-size: 1.4rem;
                }

                .banner-content p {
                    font-size: 0.9rem;
                }

                .logo-container {
                    justify-content: center;
                    margin-top: 10px;
                }

                .container {
                    padding: 15px;
                }
            }
        </style>
    </head>
    <body>

        <!-- Banner with text and logos -->
        <div class="banner">
            <!-- Text Content -->
            <div class="banner-content">
                <h2 class="mb-0">PT. Telkom Indonesia Tbk. - Unit BGES</h2>
                <p> Jl. Jend. Sudirman No.459, 20 Ilir D. III, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30129</p>
            </div>

            <!-- Logo Container -->
            <div class="logo-container">
                <img src="{{ asset('images/telkom.png') }}" alt="Telkom">
                <img src="{{ asset('images/bumn.png') }}" alt="BUMN">
            </div>
        </div>

        <div class="container">
            <h1>@yield('header')</h1>
            @yield('content')
        </div>
        <!-- Logout Button -->
        <div class="d-flex justify-content-end mb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
