@extends('layouts.app')

@section('header', '')

@section('content')
<div class="container mt-4">
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h2 class="text-lg font-semibold mb-2 mb-md-0">
            Delete Forms
        </h2>
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            Go to Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('form.create') }}" class="nav-link">
                            Go to Create Form
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <!-- Search Bar and Sorter -->
            <div class="mb-4 d-flex flex-column flex-md-row gap-3 align-items-center">
                <div class="flex-grow-1 w-100">
                    <input type="text" id="search-input" placeholder="Cari Nama Tamu" class="form-control form-control-lg" autocomplete="off" maxlength="20" value="{{ $searchQuery ?? '' }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="sorter-container">
                    <select id="sort-select" class="form-control form-control-lg sorter-select">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>
            </div>

            <!-- Custom Table -->
            <div class="table-container mb-4">
                <table class="custom-table">
                    <thead>
                        <tr class="custom-table-header">
                            <th>Date</th>
                            <th>Guest Name</th>
                            <th>Institution</th>
                            <th>Taken By</th>
                            <th>Invoice Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="form-list">
                        @include('partials.delete-tabel', ['forms' => $forms])
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination d-flex justify-content-center flex-wrap gap-2">
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

<!-- JavaScript for Real-Time Search -->
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

    // Add event listener for sort select
    document.getElementById('sort-select').addEventListener('change', function() {
        let sortQuery = this.value;
        let searchQuery = document.getElementById('search-input').value;

        window.location.href = `{{ route('form.deleteScreen') }}?search=${searchQuery}&sort=${sortQuery}`;
    });
</script>
@endsection
