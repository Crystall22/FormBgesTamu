@extends('layouts.app')

@php
    $userRole = auth()->user()->role ?? '';
    $type = '';
    if(Str::startsWith($userRole, 'management')) {
        // Ambil tipe dari role, misal: management-hrd => hrd
        $type = Str::after($userRole, 'management-');
    }
@endphp

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-bell fa-2x text-primary me-2"></i>
        <h4 class="mb-0 fw-bold">Notifikasi Anda</h4>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($notifs as $notif)
                    @php
                        if(Str::startsWith($userRole, 'secretary')) {
                            $notifUrl = route('secretary.form', $notif->form_id ?? 0);
                        }
                        elseif(Str::startsWith($userRole, 'management')) {
                            $notifUrl = route('management.dashboard', [
                                'type' => $type,
                                'highlight' => $notif->form_id
                            ]);
                        }
                        else {
                            $notifUrl = $notif->form_id ? route('dashboard.detail', $notif->form_id) : '#';
                        }
                    @endphp
                    <a
                        href="{{ $notifUrl }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center notif-row"
                        style="transition: background 0.2s;"
                    >
                        <div>
                            <div class="fw-semibold">{{ $notif->message }}</div>
                            <div class="small text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $notif->created_at->format('d-m-Y H:i') }}
                            </div>
                        </div>
                        @if($notif->form_id)
                            <span class="badge bg-primary rounded-pill ms-2">Lihat Form</span>
                        @endif
                    </a>
                @empty
                    <div class="text-muted py-4 text-center">Tidak ada notifikasi.</div>
                @endforelse
            </div>
        </div>
        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-center">
                {{ $notifs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.notif-row:hover {
    background: #e3f2fd !important;
    text-decoration: none;
}
</style>
@endpush
