{{-- filepath: resources/views/parkings/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-parking text-primary me-2"></i>
            Parking List
        </h3>
        <a href="{{ route('parkings.create') }}" class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
            <i class="fas fa-plus"></i> Add Parking
        </a>
    </div>

    <div class="row g-3">
        @forelse ($parkings as $parking)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm parking-card text-center py-4" style="cursor:pointer; background:transparent;" data-href="{{ route('parkings.edit', $parking->id) }}">
                    <div class="d-flex flex-column align-items-center">
                        <span class="avatar avatar-xl rounded-circle shadow mb-2"
                              style="background:rgba(0,0,0,0.03); width:80px; height:80px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-car fa-3x"
                               style="color:
                                    {{ $parking->status == 'available' ? '#28a745' : ($parking->status == 'vacant' ? '#dc3545' : '#ffc107') }};
                               "></i>
                        </span>
                        <div class="fw-bold fs-5 mt-2" style="letter-spacing:2px;">
                            {{ preg_replace('/([A-Za-z]{1,2})(\d{1,4})([A-Za-z]{0,4})/', '$1 $2 $3', $parking->license_number) }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow text-center p-5 bg-transparent">
                    <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                    <h5 class="fw-semibold">No Parking Data</h5>
                    <p class="text-muted">There are currently no parking records to display.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.parking-card').forEach(card => {
            card.addEventListener('click', function () {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>
@endpush
@endsection
