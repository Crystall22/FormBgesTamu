@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-ticket-alt text-primary me-2"></i> Nomor Antrian Anda
        </div>
        <div class="card-body text-center">
            <h1 class="display-1 fw-bold text-primary">{{ $queue->queue_number }}</h1>
            <p class="mt-3">Terima kasih, {{ $queue->name }}!</p>
            <p>Nomor telepon: {{ $queue->phone }}</p>
            <p>Nomor pelanggan: {{ $queue->customer_id }}</p>
            <p class="text-muted">Silakan tunggu panggilan dari Customer Service.</p>
            <a href="{{ route('queue.create') }}" class="btn btn-secondary mt-4">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
