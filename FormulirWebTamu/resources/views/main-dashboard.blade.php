@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-3">Dashboard Utama</h3>
    <div class="row g-4 mb-4">
        <!-- Statistik Ringkas -->
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0 gradient-primary text-white">
                <div class="card-body d-flex align-items-center">
                    <span class="icon bg-white text-primary rounded-circle me-3" style="padding:12px;">
                        <i class="fas fa-users fa-lg"></i>
                    </span>
                    <div>
                        <div class="fw-bold fs-5">{{ $totalUsers }}</div>
                        <div class="small">Total Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0 gradient-success text-white">
                <div class="card-body d-flex align-items-center">
                    <span class="icon bg-white text-success rounded-circle me-3" style="padding:12px;">
                        <i class="fas fa-file-alt fa-lg"></i>
                    </span>
                    <div>
                        <div class="fw-bold fs-5">{{ $totalForms }}</div>
                        <div class="small">Total Form</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0 gradient-warning text-white">
                <div class="card-body d-flex align-items-center">
                    <span class="icon bg-white text-warning rounded-circle me-3" style="padding:12px;">
                        <i class="fas fa-bell fa-lg"></i>
                    </span>
                    <div>
                        <div class="fw-bold fs-5">{{ $unreadNotifs }}</div>
                        <div class="small">Notifikasi Baru</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0 gradient-info text-white">
                <div class="card-body d-flex align-items-center">
                    <span class="icon bg-white text-info rounded-circle me-3" style="padding:12px;">
                        <i class="fas fa-calendar-check fa-lg"></i>
                    </span>
                    <div>
                        <div class="fw-bold fs-5">{{ $todayForms }}</div>
                        <div class="small">Form Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Akses Sidebar -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-th-large text-primary me-2"></i> Menu Akses Cepat
                </div>
                <div class="card-body d-flex flex-wrap gap-3">
                    <a href="{{ route('notifications.page') }}" class="btn btn-outline-primary">
                        <i class="fas fa-bell me-1"></i> Notifikasi
                    </a>
                    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-user me-1"></i> Profil Saya
                    </a>
                    <a href="{{ route('chat.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-comments me-1"></i> Chat
                    </a>
                    @if(auth()->user()->role === 'receptionist')
                        <a href="{{ route('receptionist.dashboard') }}" class="btn btn-outline-success">
                            <i class="fas fa-table me-1"></i> Dashboard Receptionist
                        </a>
                    @endif
                    @if(auth()->user()->role === 'secretary')
                        <a href="{{ route('secretary.dashboard') }}" class="btn btn-outline-info">
                            <i class="fas fa-user-tie me-1"></i> Dashboard Secretary
                        </a>
                    @endif
                    @if(str_starts_with(auth()->user()->role, 'management'))
                        <a href="{{ route('management.dashboard', ['type' => \Illuminate\Support\Str::after(auth()->user()->role, 'management-')]) }}" class="btn btn-outline-warning">
                            <i class="fas fa-briefcase me-1"></i> Dashboard Management
                        </a>
                    @endif
                    @if(auth()->user()->role === 'customer_service')
                        <a href="{{ route('customerservice.modem.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-headset me-1"></i> Modem
                        </a>
                        <a href="{{ route('customerservice.queue-list') }}" class="btn btn-outline-danger">
                            <i class="fas fa-headset me-1"></i> Antrian Customer Service
                        </a>
                        <a href="{{ route('customerservice.call-center.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-headset me-1"></i> Call Center
                        </a>
                    @endif
                    @if(auth()->user()->role === 'security')
                        <a href="{{ route('security.dashboard') }}" class="btn btn-outline-warning">
                            <i class="fas fa-shield-alt me-1"></i> Dashboard Security
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Pengaduan Widget & Pie Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-exclamation-circle text-danger me-2"></i> Jumlah Pengaduan</span>
                    <form method="get" class="d-inline">
                        <input type="text" name="complaint_range" class="form-control form-control-sm d-inline-block" style="width:160px;display:inline;" placeholder="Pilih rentang tanggal" value="{{ request('complaint_range') }}" autocomplete="off">
                        <button class="btn btn-sm btn-outline-primary">Filter</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="fw-bold fs-4 mb-2">{{ $totalComplaints }}</div>
                    <canvas id="complaintPieChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <!-- Widget & Grafik Pengambilan Nomor -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-ticket-alt text-success me-2"></i> Pengambilan Nomor Antrian</span>
                    <form method="get" class="d-inline">
                        <input type="text" name="queue_range" class="form-control form-control-sm d-inline-block" style="width:160px;display:inline;" placeholder="Pilih rentang tanggal" value="{{ request('queue_range') }}" autocomplete="off">
                        <button class="btn btn-sm btn-outline-primary">Filter</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="fw-bold fs-4 mb-2">Hari Ini: {{ $todayQueues }}</div>
                    <canvas id="queueLineChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white fw-bold">
            <i class="fas fa-bullhorn text-warning me-2"></i> Pengumuman / Aktivitas Terbaru
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @forelse($recentActivities as $activity)
                    <li class="list-group-item px-0">
                        <span class="fw-semibold">{{ $activity['title'] }}</span>
                        <div class="small text-muted">{{ $activity['time'] }}</div>
                    </li>
                @empty
                    <li class="list-group-item px-0 text-muted">Belum ada aktivitas terbaru.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3em;
}
.gradient-primary { background: linear-gradient(60deg, #007bff 0%, #0056b3 100%) !important; }
.gradient-success { background: linear-gradient(60deg, #28a745 0%, #218838 100%) !important; }
.gradient-warning { background: linear-gradient(60deg, #ffc107 0%, #e0a800 100%) !important; }
.gradient-info { background: linear-gradient(60deg, #17a2b8 0%, #117a8b 100%) !important; }
.card { border-radius: 1rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Flatpickr untuk filter pengaduan
    flatpickr("input[name='complaint_range']", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "id"
    });
    flatpickr("input[name='queue_range']", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "id"
    });

    var ctxPie = document.getElementById('complaintPieChart').getContext('2d');
    var complaintPie = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($complaintByCategory)) !!},
            datasets: [{
                data: {!! json_encode(array_values($complaintByCategory)) !!},
                backgroundColor: ['#ff6384','#36a2eb','#ffce56','#4bc0c0','#9966ff','#ff9f40'],
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    var ctxLine = document.getElementById('queueLineChart').getContext('2d');
    var queueLine = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($queuePerDay)) !!},
            datasets: [{
                label: 'Pengambilan Nomor',
                data: {!! json_encode(array_values($queuePerDay)) !!},
                fill: true,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40,167,69,0.1)',
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#28a745'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endpush
