@extends('layouts.app')

@section('header', '')

@section('content')
<div class="container mt-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <p2 class="text-lg font-semibold">
            Delete Forms
        </p2>
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Search Bar -->
            <div class="mb-4">
                <input type="text" id="search-input" maxlength="20 placeholder="Cari Nama Tamu" class="form-control" autocomplete="off" value="{{ $searchQuery ?? '' }}">
            </div>

            <!-- Sorter Buttons -->
            <div class="mb-4">
                <a href="?sort=asc" class="btn btn-sm btn-primary {{ request('sort') == 'asc' ? 'active' : '' }}">
                    Sort Oldest First
                </a>
                <a href="?sort=desc" class="btn btn-sm btn-primary {{ request('sort') == 'desc' ? 'active' : '' }}">
                    Sort Newest First
                </a>
            </div>
            <!-- Table with Responsive Scroll -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
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
            <div class="pagination">
                {{-- Previous Page Link --}}
                @if ($forms->onFirstPage())
                    <a class="disabled" href="#">&laquo;</a>
                @else
                    <a href="{{ $forms->previousPageUrl() }}">&laquo;</a>
                @endif

                {{-- Pagination Links --}}
                @for ($i = 1; $i <= $forms->lastPage(); $i++)
                    <a href="{{ $forms->url($i) }}" class="{{ ($forms->currentPage() == $i) ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Next Page Link --}}
                @if ($forms->hasMorePages())
                    <a href="{{ $forms->nextPageUrl() }}">&raquo;</a>
                @else
                    <a class="disabled" href="#">&raquo;</a>
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
</script>
@endsection
