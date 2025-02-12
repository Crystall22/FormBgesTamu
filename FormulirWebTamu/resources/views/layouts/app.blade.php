<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Formulir Web Tamu')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 960px;
            margin: auto;
            padding: 20px;
        }
        .btn {
            margin: 5px 0;
        }
        .form-control {
            margin-bottom: 10px;
        }
        /* Styling for the full-width banner */
        .banner {
            background-color: #e26671;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }
        .banner img {
            max-height: 60px;
            margin-right: 20px;
        }
    </style>
</head>
<body>

    <!-- Banner with logo and title -->
    <div class="banner">
        <img src="{{ asset('images/logotelkom.png') }}" alt="Logo" style="width: 110px; height: auto;">
        <div>
            <h1 class="mb-0">PT Telkom Indonesia Tbk - UNIT BGES</h1>
            <p class="lead">Jl. Jend. Sudirman No.459, 20 Ilir D. III, Kec. Ilir Tim. I, Kota Palembang, Sumatera Selatan 30129</p>
        </div>
    </div>

    <div class="container">
        <h1>@yield('header')</h1>
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
