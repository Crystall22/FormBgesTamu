<!-- filepath: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Formulir Web Tamu')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    @stack('styles')
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="dark">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if(auth()->user() && auth()->user()->role === 'receptionist')
                        <li class="nav-item {{ request()->is('form/create') ? 'active' : '' }}">
                            <a href="{{ route('form.create') }}">
                                <i class="fas fa-edit"></i>
                                <p>Buat Form Tamu</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('receptionist/deleteform') ? 'active' : '' }}">
                            <a href="{{ route('form.deleteScreen') }}">
                                <i class="fas fa-trash"></i>
                                <p>Delete Form</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user() && auth()->user()->role === 'secretary')
                        <li class="nav-item {{ request()->is('secretary/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('secretary.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <p>Secretary Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-users-cog"></i>
                                <p>User Manager</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user() && auth()->user()->role === 'security')
                        <li class="nav-item {{ request()->is('parkings*') ? 'active' : '' }}">
                            <a href="{{ route('parkings.index') }}">
                                <i class="fas fa-parking"></i>
                                <p>Parking Management</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user() && str_starts_with(auth()->user()->role, 'management'))
                        <li class="nav-item {{ request()->is('management/dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('management.dashboard', auth()->user()->role) }}">
                                <i class="fas fa-briefcase"></i>
                                <p>Management Dashboard</p>
                            </a>
                        </li>
                    @endif

                    <!-- Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logoutFormSidebar">
                            @csrf
                            <a href="#" onclick="document.getElementById('logoutFormSidebar').submit(); return false;">
                                <i class="fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
            </div>
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <span class="profile-username ms-2">
                                <span class="fw-bold">
                                    {{ auth()->user()->name ?? 'Guest' }}
                                </span>
                                <span class="badge bg-primary ms-1 text-capitalize">
                                    {{ auth()->user()->role ?? session('role') ?? '' }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <div class="container">
            <div class="page-inner py-4">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="http://www.themekita.com">ThemeKita</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Help</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Licenses</a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    2025, made with <i class="fa fa-heart heart text-danger"></i> by
                    <a href="http://www.themekita.com">ThemeKita</a>
                </div>
                <div>
                    Created by <b>Muhyi Haadi Sewithto</b> | Universitas Multi Data Palembang
                </div>
            </div>
        </footer>
    </div>
</div>

<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
<script src="{{ asset('assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script>
@stack('scripts')
</body>
</html>
