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
                <a href="{{ url('/') }}" class="logo d-flex justify-content-center align-items-center" style="height:90px;">
                    <img src="{{ asset('images/telkom2.png') }}" alt="navbar brand" class="navbar-brand"
                        style="max-height: 80px; max-width: 95%; object-fit: contain; margin: 0 auto; display: block;" />
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
            <div class="sidebar-content" style="display: flex; flex-direction: column; height: 100%;">
                <ul class="nav nav-secondary" style="flex: 1 1 auto;">
                    {{-- Dashboard (semua role) --}}
                    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Receptionist --}}
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

                    {{-- Secretary --}}
                    @if(auth()->user() && auth()->user()->role === 'secretary')
                        <li class="nav-item submenu {{ request()->is('secretary/dashboard') || request()->is('users*') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#secretaryMenu" role="button" aria-expanded="{{ request()->is('secretary/dashboard') || request()->is('users*') ? 'true' : 'false' }}">
                                <i class="fas fa-user-tie"></i>
                                <p>Secretary</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('secretary/dashboard') || request()->is('users*') ? 'show' : '' }}" id="secretaryMenu">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('secretary/dashboard') ? 'active' : '' }}">
                                        <a href="{{ route('secretary.dashboard') }}">
                                            <span class="sub-item"><i class="fas fa-tachometer-alt"></i> Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('users*') ? 'active' : '' }}">
                                        <a href="{{ route('users.index') }}">
                                            <span class="sub-item"><i class="fas fa-users-cog"></i> User Manager</span>
                                        </a>
                                        {{-- Tombol tambah user langsung di sidebar --}}
                                        <a href="{{ route('users.create') }}" class="ms-4 d-block mt-1">
                                            <span class="sub-item text-success"><i class="fas fa-user-plus"></i> Tambah User</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    {{-- Security --}}
                    @if(auth()->user() && auth()->user()->role === 'security')
                        <li class="nav-item submenu {{ request()->is('parkings*') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#securityMenu" role="button" aria-expanded="{{ request()->is('parkings*') ? 'true' : 'false' }}">
                                <i class="fas fa-shield-alt"></i>
                                <p>Security</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('parkings*') ? 'show' : '' }}" id="securityMenu">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('parkings') ? 'active' : '' }}">
                                        <a href="{{ route('parkings.index') }}">
                                            <span class="sub-item"><i class="fas fa-parking"></i> Parking Management</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('parkings/create') ? 'active' : '' }}">
                                        <a href="{{ route('parkings.create') }}">
                                            <span class="sub-item text-success"><i class="fas fa-plus"></i> Tambah Parkir</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    {{-- Management (role: management-business, management-government, management-enterprise) --}}
                    @if(auth()->user() && str_starts_with(auth()->user()->role, 'management-'))
                        <li class="nav-item {{ request()->is('management/dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('management.dashboard', explode('-', auth()->user()->role)[1] ?? 'business') }}">
                                <i class="fas fa-briefcase"></i>
                                <p class="d-flex align-items-center gap-1">
                                    Dashboard
                                    <span class="badge bg-info ms-2 text-capitalize text-truncate"
                                          style="max-width: 90px; font-size:0.85em;"
                                          data-bs-toggle="tooltip"
                                          title="{{ ucfirst(explode('-', auth()->user()->role)[1] ?? 'Business') }}">
                                        {{ ucfirst(Str::limit(explode('-', auth()->user()->role)[1] ?? 'Business', 12)) }}
                                    </span>
                                </p>
                            </a>
                        </li>
                    @endif

                    {{-- Chat --}}
                    <li class="nav-item {{ request()->is('chat*') ? 'active' : '' }}">
                        <a href="{{ route('chat.index') }}">
                            <i class="fas fa-comments"></i>
                            <p>Chat</p>
                        </a>
                    </li>
                </ul>
                {{-- Logout di paling bawah --}}
                {{-- Sidebar Logout --}}
                <ul class="nav nav-secondary mt-auto mb-3">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logoutFormSidebar">
                            @csrf
                            <a href="#" onclick="document.getElementById('logoutFormSidebar').submit(); return false;">
                                <i class="fas fa-sign-out-alt text-danger"></i>
                                <p class="text-danger fw-bold mb-0">Logout</p>
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
            {{-- Navbar Profile --}}
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none" title="Profile">
                                @if(auth()->user() && auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                        alt="Foto Profil"
                                        class="rounded-circle"
                                        width="40" height="40"
                                        style="object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=0D8ABC&color=fff"
                                        alt="Foto Profil"
                                        class="rounded-circle"
                                        width="40" height="40">
                                @endif
                            </a>
                            <span class="ms-2">
                                <span class="badge bg-primary ms-1 text-capitalize">
                                    {{ str_replace('management-', 'management ', auth()->user()->role ?? session('role') ?? '') }}
                                </span>
                                <span class="fw-bold">{{ auth()->user()->name ?? 'Guest' }}</span>
                            </span>
                        </li>

                        {{-- Di navbar header --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell fa-lg"></i>
                                <span id="notif-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.75em;display:none;">
                                    {{-- Akan diisi JS --}}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:300px;">
                                <li class="dropdown-header fw-bold">Notifikasi</li>
                                <li>
                                    <div id="notif-list" class="px-3 py-2 text-muted small">Tidak ada notifikasi baru.</div>
                                </li>
                            </ul>
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
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Licenses</a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    Copyright@2025, Affiliation <i class="fa fa-heart heart text-danger"></i> with
                    <a href="https://www.telkom.co.id">Telkom Indonesia</a>
                </div>
                <div>
                    Created by <b>Muhyi Haadi Sewithto</b> | Universitas Multi Data Palembang
                    <br>
                    Mentored by <b>Agus Andreansyah</b>  | PT. Telkom Indonesia
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
@push('scripts')
<script>
setInterval(function() {
    $.get("{{ route('chat.unread.count') }}", function(data) {
        if(data.new_message) {
            Swal.fire({
                icon: 'info',
                title: 'Pesan Baru!',
                text: data.text,
                timer: 2500,
                showConfirmButton: false
            });
        }
        $('#notif-badge').text(data.count > 0 ? data.count : '').toggle(data.count > 0);
    });
}, 5000);
</script>
@endpush

@push('scripts')
<script>
function loadNotif() {
    $.get("{{ route('chat.unread.list') }}", function(data) {
        $('#notif-list').html(data.html);
        $('#notif-badge').text(data.count > 0 ? data.count : '').toggle(data.count > 0);
    });
}
$(function(){
    loadNotif();
    setInterval(loadNotif, 10000);
});
</script>
@endpush
</body>
</html>
