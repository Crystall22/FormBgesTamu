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
            <div class="mb-4 d-flex justify-between align-items-center">
                <p2 class="text-lg font-semibold">
                    Form Lists
                </p2>
                <div class="ml-auto">
                    <a href="{{ url()->previous() }}"
                        class="btn btn-lg btn-outline-secondary px-2 py-1 rounded-lg transition duration-300
                        ease-in-out hover:bg-gray-200 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i> Go Back
                    </a>
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input type="text" id="search-input" placeholder="Cari Nama Tamu"
                            class="form-control" autocomplete="off">
                    </div>
                    <div class="table-responsive">
                            <!-- Form/Pagination -->
                            <div id="form-list">
                                @include('partials.tabel', ['forms' => $forms])
                            </div>
                            </tbody>
                        </table>
                    </div>

                    <!-- JavaScript Real-Time Search -->
                    <script>
                        document.getElementById('search-input').addEventListener('input', function() {
                            let searchQuery = this.value;

                            fetch(`{{ route('dashboard') }}?search=${searchQuery}`, {
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
                </div>
            </div>
        </div>
@endsection
