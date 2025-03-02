<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'E-Form BGES')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('style.css') }}">
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
