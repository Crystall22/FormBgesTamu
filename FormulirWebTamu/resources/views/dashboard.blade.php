@extends('layouts.app')

@section('header', '')

@section('content')

        <style>
            .table-responsive {
                width: 100%;
                overflow-x: auto;
            }

            table.table {
                width: 100%;
                border-collapse: collapse;
            }

            table.table th, table.table td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            @media (max-width: 768px) {
                table.table th, table.table td {
                    white-space: nowrap;
                }
            }
        </style>

        <!-- Isi -->
        <div class="py-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p2 class="text-lg font-semibold">Form Lists</p2>
                <nav class="navbar navbar-expand-lg navbar-light ml-auto">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            @if (session('role') === 'receptionist')
                                <li class="nav-item">
                                    <a href="{{ route('form.create') }}" class="nav-link">
                                        Go to Create Form
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('form.deleteScreen') }}" class="nav-link">
                                        Go to Delete Form
                                    </a>
                                </li>
                            @elseif (session('role') === 'secretary')
                                <li class="nav-item">
                                    <a href="{{ route('secretary.dashboard') }}" class="nav-link">
                                        Secretary Dashboard
                                    </a>
                                </li>
                            @elseif (session('role') === 'management')
                                <li class="nav-item">
                                    <a href="{{ route('management.dashboard') }}" class="nav-link">
                                        Management Dashboard
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Search Bar -->
                <div class="mb-4">
                    <input type="text" id="search-input" placeholder="Cari Nama Tamu" class="form-control"
                    autocomplete="off" maxlength="20" value="{{ $searchQuery ?? '' }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>


                <!-- Sorter Buttons -->
                <div class="mb-4">
                    <a href="?sort=asc{{ request()->has('search') ? '&search='.request('search') : '' }}" class="btn btn-sm btn-primary {{ request('sort') == 'asc' ? 'active' : '' }}">
                        Sort Oldest First
                    </a>
                    <a href="?sort=desc{{ request()->has('search') ? '&search='.request('search') : '' }}" class="btn btn-sm btn-primary {{ request('sort') == 'desc' ? 'active' : '' }}">
                        Sort Newest First
                    </a>
                </div>

                <div class="table-responsive">
                    <!-- Form/Pagination -->
                    <div id="form-list">
                        @include('partials.tabel', ['forms' => $forms])
                    </div>
                    <div class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($forms->onFirstPage())
                            <a class="disabled" href="#">&laquo;</a>
                        @else
                            <a href="{{ $forms->previousPageUrl() }}{{ request()->has('search') ? '&search='.request('search') : '' }}{{ request()->has('sort') ? '&sort='.request('sort') : '' }}">&laquo;</a>
                        @endif

                        {{-- Pagination Links --}}
                        @for ($i = 1; $i <= $forms->lastPage(); $i++)
                            <a href="{{ $forms->url($i) }}{{ request()->has('search') ? '&search='.request('search') : '' }}{{ request()->has('sort') ? '&sort='.request('sort') : '' }}" class="{{ ($forms->currentPage() == $i) ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($forms->hasMorePages())
                            <a href="{{ $forms->nextPageUrl() }}{{ request()->has('search') ? '&search='.request('search') : '' }}{{ request()->has('sort') ? '&sort='.request('sort') : '' }}">&raquo;</a>
                        @else
                            <a class="disabled" href="#">&raquo;</a>
                        @endif
                    </div>

                    <!-- JavaScript Real-Time Search dan Sort -->
                    <script>
                        document.getElementById('search-input').addEventListener('input', function() {
                            let searchQuery = encodeURIComponent(this.value); // Encode special characters
                            let sortQuery = new URLSearchParams(window.location.search).get('sort') || 'desc'; // Retain sort query

                            fetch(`{{ route('dashboard') }}?search=${searchQuery}&sort=${sortQuery}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('form-list').innerHTML = data.html;
                            })
                            .catch(error => console.error('Error fetching data:', error));
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
