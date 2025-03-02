@extends('layouts.app')

@section('header', '')

@section('content')
    <div class="py-12">
        <div class="mb-4 d-flex justify-between align-items-center">
            <p2 class="text-lg font-semibold">
                Delete Forms
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
                @if($forms->hasPages())
                    <div class="mt-4">
                        {{ $forms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for Real-Time Search -->
    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            let searchQuery = this.value;

            fetch(`{{ route('form.deleteScreen') }}?search=${searchQuery}`, {
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
