{{-- filepath: resources/views/receptionist/deleteform.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container page-inner">
    <div class="page-header mb-4">
        <h3 class="fw-bold mb-3">
            <i class="fas fa-trash-alt text-danger me-2"></i>
            Delete Guest Forms
        </h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Receptionist</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Delete Form</a>
            </li>
        </ul>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <!-- Fitur Hapus Berdasarkan Periode -->
            <form action="{{ route('form.bulkDelete') }}" method="POST" class="row g-2 align-items-end mb-4">
                @csrf
                <div class="col-md-3">
                    <label for="start_date" class="form-label mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Berdasarkan Periode
                    </button>
                </div>
            </form>

            <!-- Search Bar and Sorter -->
            <div class="row mb-4 align-items-center g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" id="search-input" placeholder="Cari Nama Tamu" class="form-control" autocomplete="off" maxlength="20" value="{{ $searchQuery ?? '' }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="sort-select" class="form-select">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive mb-4">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-calendar-day"></i> Date</th>
                            <th><i class="fas fa-user"></i> Guest Name</th>
                            <th><i class="fas fa-building"></i> Institution</th>
                            <th><i class="fas fa-user-check"></i> Taken By</th>
                            <th><i class="fas fa-file-invoice"></i> Invoice Number</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody id="form-list">
                        @include('partials.delete-tabel', ['forms' => $forms])
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @if ($forms->onFirstPage())
                    <a class="btn btn-primary btn-sm disabled" href="#">«</a>
                @else
                    <a href="{{ $forms->previousPageUrl() }}" class="btn btn-primary btn-sm">«</a>
                @endif

                @for ($i = 1; $i <= $forms->lastPage(); $i++)
                    <a href="{{ $forms->url($i) }}" class="btn btn-primary btn-sm {{ ($forms->currentPage() == $i) ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($forms->hasMorePages())
                    <a href="{{ $forms->nextPageUrl() }}" class="btn btn-primary btn-sm">»</a>
                @else
                    <a class="btn btn-primary btn-sm disabled" href="#">»</a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('search-input').addEventListener('input', function() {
        let searchQuery = this.value;
        let sortQuery = new URLSearchParams(window.location.search).get('sort') || 'desc';

        fetch(`{{ route('form.deleteScreen') }}?search=${searchQuery}&sort=${sortQuery}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('form-list').innerHTML = data.html;
        });
    });

    document.getElementById('sort-select').addEventListener('change', function() {
        let sortQuery = this.value;
        let searchQuery = document.getElementById('search-input').value;

        window.location.href = `{{ route('form.deleteScreen') }}?search=${searchQuery}&sort=${sortQuery}`;
    });
</script>
@endpush
@endsection
