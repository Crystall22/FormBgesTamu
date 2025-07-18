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
            <div class="d-flex justify-content-center mt-4 gap-2">
                <button id="backQueueButton" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
                <button id="repeatQueueButton" class="btn btn-outline-success px-4">
                    <i class="fas fa-volume-up"></i> Ulangi Suara
                </button>
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
        const backButton = document.getElementById('backQueueButton');
        const repeatButton = document.getElementById('repeatQueueButton');
        let currentIndex = parseInt(localStorage.getItem('currentQueueIndex')) || 0;

        function displayQueue(index) {
            const cards = queueWidget.querySelectorAll('.card');
            cards.forEach((card, i) => {
                card.style.display = i === index ? 'block' : 'none';
            });
        }

        function callQueue(index) {
            const cards = queueWidget.querySelectorAll('.card');
            if (cards.length === 0) return;
            const card = cards[index];
            if (!card) return;

            const queueNumber = card.querySelector('.display-4').textContent;
            const name = card.querySelector('.fw-bold.mb-1') ? card.querySelector('.fw-bold.mb-1').textContent : '';

            let text = `Nomor antrian ${queueNumber}`;
            if (name) text += `. Atas nama ${name}`;

            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel(); // Stop suara sebelumnya jika ada
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                window.speechSynthesis.speak(utterance);
            } else {
                alert('Browser Anda tidak mendukung pemanggilan suara.');
            }
        }

        nextButton.addEventListener('click', function () {
            const cards = queueWidget.querySelectorAll('.card');
            if (cards.length === 0) {
                alert('Tidak ada antrian. Semua antrian telah selesai.');
                return;
            }
            currentIndex = (currentIndex + 1) % cards.length;
            localStorage.setItem('currentQueueIndex', currentIndex);
            displayQueue(currentIndex);
            callQueue(currentIndex);
        });

        backButton.addEventListener('click', function () {
            const cards = queueWidget.querySelectorAll('.card');
            if (cards.length === 0) {
                alert('Tidak ada antrian.');
                return;
            }
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            localStorage.setItem('currentQueueIndex', currentIndex);
            displayQueue(currentIndex);
            callQueue(currentIndex);
        });

        repeatButton.addEventListener('click', function () {
            callQueue(currentIndex);
        });

        displayQueue(currentIndex);
        callQueue(currentIndex);
    });
</script>
@endpush
@endsection
