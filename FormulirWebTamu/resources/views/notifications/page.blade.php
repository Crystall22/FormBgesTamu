{{-- filepath: resources/views/notifications/page.blade.php --}}
@extends('layouts.app')

@php
    use Illuminate\Support\Str;
    $userRole = auth()->user()->role ?? '';
    $type = '';
    if(Str::startsWith($userRole, 'management')) {
        $type = Str::after($userRole, 'management-');
    }
@endphp

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white d-flex align-items-center">
                    <span class="icon bg-primary text-white rounded-circle me-3" style="padding:10px;">
                        <i class="fa fa-bell fa-lg"></i>
                    </span>
                    <h4 class="mb-0 fw-bold">Notifikasi Anda</h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifs as $notif)
                            @php
                                $message = $notif->message
                                    ?? ($notif->data['message'] ?? (is_string($notif->data) ? json_decode($notif->data, true)['message'] ?? '' : ''));
                                $formId = $notif->form_id
                                    ?? ($notif->data['form_id'] ?? (is_string($notif->data) ? json_decode($notif->data, true)['form_id'] ?? null : null));

                                if(Str::startsWith($userRole, 'secretary')) {
                                    $notifUrl = route('secretary.form', $formId ?? 0);
                                }
                                elseif(Str::startsWith($userRole, 'management')) {
                                    $notifUrl = route('management.dashboard', [
                                        'type' => $type,
                                        'highlight' => $formId
                                    ]);
                                }
                                else {
                                    $notifUrl = $formId ? route('dashboard.detail', $formId) : '#';
                                }
                                $isUnread = is_null($notif->read_at);
                            @endphp
                            <div class="list-group-item px-0 py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between notif-row {{ $isUnread ? 'notif-unread' : '' }}">
                                <div class="d-flex align-items-center mb-2 mb-md-0 flex-grow-1">
                                    <span class="icon bg-light text-primary rounded-circle me-3" style="padding:8px;">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <div>
                                        <div class="fw-semibold">{{ $message }}</div>
                                        <div class="small text-muted mt-1 d-flex align-items-center flex-wrap">
                                            <i class="fa fa-clock me-1"></i>
                                            {{ $notif->created_at->format('d-m-Y H:i') }}
                                            <a href="{{ route('notifications.read', $notif->id) }}" class="ms-3 text-decoration-underline" style="font-size: 0.9em;">Tandai Sudah Dibaca</a>
                                            @if($isUnread)
                                                <span class="badge bg-info text-dark ms-2">Baru</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mt-2 mt-md-0">
                                    @if($formId)
                                        <a href="{{ $notifUrl }}" class="btn btn-primary btn-sm px-4 ms-md-4 me-2" style="min-width:100px;">Lihat Form</a>
                                    @endif
                                    <form action="{{ route('notifications.delete', $notif->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm border-0 text-danger notif-delete-btn" title="Hapus Notifikasi">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
    </div>
</div>
@endsection

@push('styles')
<style>
.notif-row {
    transition: background 0.2s;
}
.notif-row:hover {
    background: #e3f2fd !important;
    text-decoration: none;
}
.notif-unread {
    background: #e3f7ff !important;
}
.icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2em;
}
.notif-delete-btn {
    padding: 4px 8px;
    border-radius: 50%;
    background: #f8f9fa;
    transition: background 0.2s;
}
.notif-delete-btn:hover {
    background: #ffeaea;
    color: #dc3545;
}
</style>
@endpush
