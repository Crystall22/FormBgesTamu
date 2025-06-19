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
        <div>
            <a href="{{ route('parkings.pinjam') }}" class="btn btn-success btn-sm px-3 py-2 shadow-sm me-2">
                <i class="fas fa-car-side"></i> Pinjam Mobil
            </a>
            <a href="{{ route('parkings.returnForm') }}" class="btn btn-warning btn-sm px-3 py-2 shadow-sm me-2">
                <i class="fas fa-undo"></i> Pengembalian Mobil
            </a>
            <a href="{{ route('parkings.create') }}" class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                <i class="fas fa-plus"></i> Add Parking
            </a>
        </div>
    </div>

    <div class="mb-3 px-2">
        <button id="toggleViewBtn" class="btn btn-outline-primary btn-sm">Toggle Table View</button>
    </div>

    <div id="cardView" class="row g-3">
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
                        <div class="text-muted small mt-1" style="letter-spacing:1px;">
                            <span class="badge bg-light text-dark border" style="font-size: 0.95em;">
                                {{ $parking->slot ?? '-' }}
                            </span>
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

    <div id="tableView" style="display:none;">
        <div class="row mb-3 px-2">
            <div class="col-md-6 mb-2 mb-md-0">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari No Plat atau Nama Peminjam">
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width:40px;">No</th>
                                <th>No Plat</th>
                                <th>Nama Peminjam</th>
                                <th>No Parkir</th>
                                <th>Status</th>
                                <th class="text-center" style="width:90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="parkingTableBody">
                            @foreach ($parkings as $i => $parking)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ $parking->license_number }}</span>
                                    </td>
                                    <td>
                                        {{ $parking->borrower_name ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $parking->slot ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge
                                            {{ $parking->status == 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $parking->status == 'available' ? 'Tersedia' : 'Dipinjam' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('parkings.edit', $parking->id) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($parkings) == 0)
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <div>Tidak ada data parkir</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Card click navigation
        document.querySelectorAll('.parking-card').forEach(card => {
            card.addEventListener('click', function () {
                window.location.href = this.dataset.href;
            });
        });

        // Toggle view
        document.getElementById('toggleViewBtn').addEventListener('click', function () {
            document.getElementById('cardView').style.display =
                document.getElementById('cardView').style.display === 'none' ? 'flex' : 'none';
            document.getElementById('tableView').style.display =
                document.getElementById('tableView').style.display === 'none' ? 'block' : 'none';
        });

        // Search function
        document.getElementById('searchInput').addEventListener('input', function () {
            let query = this.value.toLowerCase();
            document.querySelectorAll('#parkingTableBody tr').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
</script>
@endpush
@endsection
