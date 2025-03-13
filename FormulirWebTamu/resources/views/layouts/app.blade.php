<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'E-Form BGES')</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="{{ asset('darkstyle.css') }}">
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

                <!-- Logo Container with Dark Mode Toggle -->
                <div class="logo-container">
                    <img src="{{ asset('images/bumn.png') }}" alt="BUMN">
                    <img id="telkomLogo" src="{{ asset('images/telkom.png') }}" alt="Telkom">

                    <!-- Dark Mode Toggle Button -->
                    <button class="btn btn-dark-mode" id="darkModeToggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>

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

        <script>
            // Check if dark mode is enabled on page load
            window.addEventListener('load', function() {
                const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';

                if (darkModeEnabled) {
                    enableDarkMode();
                }
            });

            document.getElementById('darkModeToggle').addEventListener('click', function() {
                const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';

                if (darkModeEnabled) {
                    disableDarkMode();
                } else {
                    enableDarkMode();
                }
            });

            function enableDarkMode() {
                document.body.classList.add('dark-mode');
                document.querySelector('.wrapper').classList.add('dark-mode');
                document.querySelector('.container').classList.add('dark-mode');
                document.querySelector('.banner').classList.add('dark-mode');
                document.querySelector('.footer').classList.add('dark-mode');
                document.querySelectorAll('h1, h2, p, table, th, td').forEach(el => el.classList.add('dark-mode'));
                document.querySelectorAll('.form-control, .btn, .pagination a, .card, .card-title').forEach(el => el.classList.add('dark-mode'));

                const telkomLogo = document.getElementById('telkomLogo');
                telkomLogo.src = "{{ asset('images/telkom2.png') }}";

                // Save dark mode state to localStorage
                localStorage.setItem('darkMode', 'enabled');
            }

            function disableDarkMode() {
                document.body.classList.remove('dark-mode');
                document.querySelector('.wrapper').classList.remove('dark-mode');
                document.querySelector('.container').classList.remove('dark-mode');
                document.querySelector('.banner').classList.remove('dark-mode');
                document.querySelector('.footer').classList.remove('dark-mode');
                document.querySelectorAll('h1, h2, p, table, th, td').forEach(el => el.classList.remove('dark-mode'));
                document.querySelectorAll('.form-control, .btn, .pagination a, .card, .card-title').forEach(el => el.classList.remove('dark-mode'));

                const telkomLogo = document.getElementById('telkomLogo');
                telkomLogo.src = "{{ asset('images/telkom.png') }}";

                // Save light mode state to localStorage
                localStorage.setItem('darkMode', 'disabled');
            }
        </script>
    </body>
</html>
