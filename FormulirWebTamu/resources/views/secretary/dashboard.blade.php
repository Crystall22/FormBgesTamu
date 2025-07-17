@extends('layouts.app')

@section('content')
<div class="container page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">
            <i class="fas fa-user-tie text-primary me-2"></i>
            Secretary Dashboard
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
                <a href="#">Secretary</a>
            </li>
        </ul>
    </div>

    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-white border-bottom-0 pb-0">
            <ul class="nav nav-pills nav-primary" id="secretaryTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="form-tab" data-bs-toggle="pill" href="#form" role="tab" aria-controls="form" aria-selected="true">
                        Formulir Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="history-tab" data-bs-toggle="pill" href="#history" role="tab" aria-controls="history" aria-selected="false">
                        Riwayat Formulir
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="secretaryTabContent">
                <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
                    <div class="row g-4">
                        @forelse ($forms as $form)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card border-0 rounded-3 shadow-lg">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-md bg-primary text-white rounded-circle me-3">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title mb-0 fw-semibold">{{ $form->guest_name ?? 'N/A' }}</h5>
                                                <small class="text-muted">{{ $form->institution ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-phone-alt text-info me-1"></i>
                                            <span class="text-muted">{{ $form->guest_phone ?? '-' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            <span class="text-muted">{{ $form->guest_address ?? '-' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-user-check text-success me-1"></i>
                                            <span class="text-muted">Taken By: {{ $form->taken ?? '-' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-calendar-alt text-warning me-1"></i>
                                            <span class="text-muted">{{ $form->created_at ? $form->created_at->format('d-m-Y H:i') : '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <a href="{{ route('secretary.form', $form->id) }}" class="btn btn-primary btn-sm px-4 py-2 shadow-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if($form->pdf_file)
                                                <a href="{{ asset('storage/'.$form->pdf_file) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card border-0 rounded-3 shadow-lg">
                                    <div class="card-body text-center p-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="fw-semibold">No Forms Available</h5>
                                        <p class="text-muted">There are currently no forms to display.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    {{-- Pagination --}}
                    @if (method_exists($forms, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $forms->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    {{-- Filter Form --}}
                    <form id="history-filter-form" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <select name="management_type" class="form-select" id="filter-management-type">
                                <option value="">Semua Management</option>
                                <option value="business">Business</option>
                                <option value="government">Government</option>
                                <option value="enterprise">Enterprise</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" name="filter_date" class="form-control" id="filter-date" placeholder="Tanggal">
                                <button type="button" class="btn btn-outline-primary" id="filter-date-btn">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" id="filter-search" placeholder="Cari nama/institusi...">
                        </div>
                    </form>
                    <div id="history-list">
                        @include('partials.history_list', ['history' => $history])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            title: 'Error!',
            text: "{{ $errors->first() }}",
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    @endif

    // Aktifkan tab sesuai parameter URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if(tab === 'history') {
            const historyTab = document.getElementById('history-tab');
            if(historyTab) {
                new bootstrap.Tab(historyTab).show();
            }
        }
        bindFilterEvents();
    });

    function bindFilterEvents() {
        // AJAX filter & search (hanya satu tanggal)
        $('#filter-management-type, #filter-search').off('change keyup').on('change keyup', function() {
            filterHistory();
        });

        $('#filter-date-btn').off('click').on('click', function() {
            filterHistory();
        });

        $('#filter-date').off('keydown').on('keydown', function(e) {
            if(e.key === 'Enter') {
                e.preventDefault();
                $('#filter-date-btn').click();
            }
        });

        // Rebind pagination links inside #history-list
        $('#history-list').off('click', '.pagination a').on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.get(url, getFilterParams(), function(data) {
                $('#history-list').html(data);
                bindFilterEvents();
            });
        });
    }

    function getFilterParams() {
        return {
            management_type: $('#filter-management-type').val(),
            filter_date: $('#filter-date').val(),
            search: $('#filter-search').val(),
            tab: 'history'
        };
    }

    function filterHistory() {
        $.get("{{ route('secretary.dashboard') }}", getFilterParams(), function(data) {
            $('#history-list').html(data);
            bindFilterEvents();
        });
    }
</script>
@endpush

@endsection
