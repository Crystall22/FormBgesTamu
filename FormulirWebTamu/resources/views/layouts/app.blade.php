<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'E-Form BGES')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                font-family: 'Gotham Rounded';
                background-color: #e42613;
                color: #333;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .wrapper {
                flex-grow: 1;
            }

            .container {
                max-width: 960px;
                margin: 30px auto;
                padding: 20px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                font-size: 2.1rem;
                color: #4d4d4d;
                font-weight: bold;
                margin-bottom: 20px;
            }

            h2 {
                font-size: 2.1rem;
                color: #000000;
                font-weight: bold;
                margin-bottom: 20px;
                font-family: 'Gotham Rounded';
            }

            p2 {
                font-size: 2.7rem;
                color: #e42613;
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
                background-color: #e42613;
                border-color: #e42613;
                color: #fff;
                transition: background-color 0.3s;
            }

            .btn-primary:hover {
                background-color: #b61c0f;
                border-color: #b61c0f;
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
                color: #b61c0f;
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
                font-family: 'Gotham Rounded';
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
                margin: 1;
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

            .banner-content1 {
                text-align: center;
                flex: 1;
                min-width: 250px;
            }

            .banner-content1 p {
                margin: 1;
                font-size: 0.9rem;
                color: #000000;
                font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            }

            /* Make the footer stick to the bottom */
            .footer {
                background-color: #ffffff;
                padding: 10px;
                text-align: center;
                color: #000000;
                width: 100%;
                box-sizing: border-box;
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
                    max-width: 100%;
                }

                h1, h2 {
                    font-size: 1.5rem;
                    font-family: 'Gotham Rounded';
                }

                .card-title {
                    font-size: 1.2rem;
                }

                .form-control {
                    padding: 10px;
                }

                .btn {
                    padding: 8px 16px;
                }
            }

            @media (max-width: 576px) {
                .container {
                    padding: 10px;
                }

                h1, h2 {
                    font-size: 1.2rem;
                    font-family: 'Gotham Rounded';
                }

                p2 {
                    font-size: 1.8rem;
                }

                .card-title {
                    font-size: 1rem;
                }

                .btn {
                    padding: 6px 12px;
                }
            }
        </style>
    </head>
    <body>

        <div class="wrapper">
            <!-- Banner with text and logos -->
            <div class="banner">
                <!-- Text Content -->
                <div class="banner-content">
                    <h2 class="mb-0">PT Telkom Indonesia Tbk - Unit BGES</h2>
                    <p> Jl. Jend. Sudirman No.459, 20 Ilir D. III, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30129</p>
                </div>

                <!-- Logo Container -->
                <div class="logo-container">
                    <img src="{{ asset('images/bumn.png') }}" alt="BUMN">
                    <img src="{{ asset('images/telkom.png') }}" alt="Telkom">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>

            <div class="container">
                <h1>@yield('header')</h1>
                @yield('content')
            </div>
        </div>

        <!-- Footer / Caption -->
        <footer class="footer">
            <div class="banner-content1">
                <p> Created by <b>Muhyi Haadi Sewithto</b> | Universitas Multi Data Palembang </p>
                <p> Mentored by <b>Agus Andreansyah</b> | Account Manager PT Telkom Indonesia</p>
                <p> copyright@2025 </p>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
