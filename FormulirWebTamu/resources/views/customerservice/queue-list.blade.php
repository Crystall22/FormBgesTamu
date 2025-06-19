@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-list text-primary me-2"></i> Daftar Nomor Antrian
        </div>
        <div class="card-body">
            <div id="queue-widget" class="d-flex justify-content-center align-items-center flex-column">
                @forelse ($queues->sortBy('created_at') as $queue)
                    <div class="card mb-4 text-center border border-secondary" style="width: 350px; display: none;" data-id="{{ $queue->id }}">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-dark">Nomor Antrian</h5>
                            <h1 class="display-4 fw-bold text-dark">{{ $queue->queue_number }}</h1>
                            <hr class="my-3">
                            <p class="fw-bold mb-1">{{ $queue->name }}</p>
                            <p class="text-muted mb-1">Nomor Telepon: {{ $queue->phone }}</p>
                            <p class="text-muted mb-1">Nomor Pelanggan: {{ $queue->customer_id }}</p>
                            <p class="text-muted">Waktu: {{ $queue->created_at->format('H:i:s') }}</p>
                            <form action="{{ route('queue.destroy', $queue->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger px-4">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <div>Tidak ada antrian</div>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button id="nextQueueButton" class="btn btn-outline-primary px-4">
                    <i class="fas fa-arrow-right"></i> Next
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const queueWidget = document.getElementById('queue-widget');
        const nextButton = document.getElementById('nextQueueButton');
        let currentIndex = parseInt(localStorage.getItem('currentQueueIndex')) || 0;

        function displayQueue(index) {
            const cards = queueWidget.querySelectorAll('.card');
            cards.forEach((card, i) => {
                card.style.display = i === index ? 'block' : 'none';
            });
        }

        nextButton.addEventListener('click', function () {
            const cards = queueWidget.querySelectorAll('.card');
            if (cards.length === 0) {
                alert('Tidak ada antrian. Semua antrian telah selesai.');
                return;
            }

            // Pindah ke antrian berikutnya
            currentIndex = (currentIndex + 1) % cards.length;
            localStorage.setItem('currentQueueIndex', currentIndex); // Simpan indeks ke localStorage
            displayQueue(currentIndex);
        });

        // Display the first queue on page load
        displayQueue(currentIndex);
    });
</script>
@endpush
@endsection
