@extends('layouts.app')

@section('header', ucfirst($type) . ' Management Dashboard')

@section('content')
@php
    $activeTab =
        request()->has('historyPage')
        || request()->get('tab') === 'history'
        || request()->get('tab') === '#history'
        ? 'history' : 'underReview';
@endphp

{{-- Search and Sort Form --}}
<div class="mb-3">
    <form method="GET" action="{{ route('management.dashboard', $type) }}" class="row g-2 align-items-center">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Cari nama tamu, institusi, atau taken..." value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>
      <input type="hidden" name="tab" value="{{ $activeTab }}">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search') || request('sort'))
                <a href="{{ route('management.dashboard', $type) }}" class="btn btn-outline-danger ms-2">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="managementTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'underReview' ? 'active' : '' }}" id="under-review-tab" data-bs-toggle="tab" href="#underReview" role="tab" aria-controls="underReview" aria-selected="{{ $activeTab == 'underReview' ? 'true' : 'false' }}">
                <i class="fas fa-tasks"></i> Under Review
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'history' ? 'active' : '' }}" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="{{ $activeTab == 'history' ? 'true' : 'false' }}">
                <i class="fas fa-history"></i> History
            </a>
        </li>
    </ul>
</div>

<div class="tab-content" id="managementTabsContent">
    <!-- Under Review Tab -->
    <div class="tab-pane fade {{ $activeTab == 'underReview' ? 'show active' : '' }}" id="underReview" role="tabpanel" aria-labelledby="under-review-tab">
        <h3 class="mb-4"><i class="fas fa-file-alt"></i> Forms Under Review</h3>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle kai-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th><i class="fas fa-user"></i> Guest Name</th>
                        <th><i class="fas fa-building"></i> Institution</th>
                        <th><i class="fas fa-user-check"></i> Taken</th>
                        <th><i class="fas fa-sticky-note"></i> Secretary Note</th>
                        <th class="kai-action-col"><i class="fas fa-cogs"></i> Actions</th>
                        <th><i class="fas fa-file-pdf"></i> PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @php $highlightId = request('highlight'); @endphp
                    @forelse($formsUnderReview as $form)
                        <tr class="text-center align-middle clickable-row{{ $highlightId == $form->id ? ' highlight-outline' : '' }}" data-url="{{ route('dashboard.detail', $form->id) }}">
                            <td>{{ $form->guest_name ?? 'N/A' }}</td>
                            <td>{{ $form->institution ?? 'N/A' }}</td>
                            <td>{{ $form->taken ?? 'N/A' }}</td>
                            <td>{{ $form->note ?? 'N/A' }}</td>
                            <td class="kai-action-col">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('management.approve', $form->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm px-3 py-1 kai-btn-action" data-bs-toggle="tooltip" title="Approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm px-3 py-1 kai-btn-action" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $form->id }}" title="Reject">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                                <!-- Modal for Reject Reason -->
                                <div class="modal fade" id="rejectModal-{{ $form->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $form->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('management.reject', $form->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="rejectModalLabel-{{ $form->id }}">
                                                        <i class="fas fa-times-circle me-2"></i>Alasan Penolakan
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="reason-{{ $form->id }}" class="form-label fw-semibold">
                                                            <i class="fas fa-comment-dots me-1 text-danger"></i>Masukkan alasan penolakan
                                                        </label>
                                                        <textarea name="reject_reason" id="reason-{{ $form->id }}" class="form-control" rows="3" required placeholder="Tulis alasan penolakan di sini..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times"></i> Tolak Form
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-primary btn-sm px-3 py-1" data-bs-toggle="tooltip" title="View PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-warning">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <div>Tidak ada data under review.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (method_exists($formsUnderReview, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $formsUnderReview->appends([
                        'historyPage' => request('historyPage'),
                        'tab' => 'underReview',
                        'search' => request('search'),
                        'sort' => request('sort')
                    ])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- History Tab -->
    <div class="tab-pane fade {{ $activeTab == 'history' ? 'show active' : '' }}" id="history" role="tabpanel" aria-labelledby="history-tab">
        <h3 class="mb-4"><i class="fas fa-history"></i> History of Accepted and Rejected Forms</h3>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle kai-table">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th><i class="fas fa-user"></i> Guest Name</th>
                        <th><i class="fas fa-phone"></i> Phone</th>
                        <th><i class="fas fa-building"></i> Institution</th>
                        <th><i class="fas fa-user-check"></i> Taken</th>
                        <th><i class="fas fa-file-invoice"></i> Invoice Number</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-comment-dots"></i> Reject Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formsHistory as $form)
                        <tr class="text-center align-middle clickable-row" data-url="{{ route('management.show', $form->id) }}">
                            <td>{{ $form->guest_name ?? 'N/A' }}</td>
                            <td>{{ $form->guest_phone ?? 'N/A' }}</td>
                            <td>{{ $form->institution ?? 'N/A' }}</td>
                            <td>{{ $form->taken ?? 'N/A' }}</td>
                            <td>{{ $form->invoice_number ?? 'N/A' }}</td>
                            <td>
                                @if ($form->status === 'approved')
                                    <span class="badge bg-success text-white"><i class="fas fa-check-circle me-1"></i>Accepted</span>
                                @elseif ($form->status === 'rejected')
                                    <span class="badge bg-danger text-white"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i>Under Review</span>
                                @endif
                            </td>
                            <td>
                                @if($form->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-dark">
                                        <i class="fas fa-comment-dots me-1"></i>
                                        {{ $form->reject_reason ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-warning">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <div>No form history available.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if (method_exists($formsHistory, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $formsHistory->appends([
                        'underReviewPage' => request('underReviewPage'),
                        'tab' => 'history',
                        'search' => request('search'),
                        'sort' => request('sort')
                    ])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .highlight-outline {
        outline: 3px solid #43a047 !important;
        outline-offset: -3px;
        background: #f6fff6 !important;
        transition: outline 0.2s, background 0.2s;
    }
    .clickable-row {
        cursor: pointer;
        transition: background 0.2s;
    }
    .clickable-row:hover {
        background: #e3f2fd !important;
    }
    .kai-action-col {
        background: #f8f9fa;
        border-left: 3px solid #007bff;
        font-weight: bold;
    }
    .kai-btn-action {
        box-shadow: 0 2px 8px rgba(0,123,255,0.15);
        font-size: 1em;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: transform 0.1s;
    }
    .kai-btn-action:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 16px rgba(0,123,255,0.25);
    }
    .kai-table th, .kai-table td {
        vertical-align: middle !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.clickable-row').forEach(function(row) {
            row.addEventListener('click', function(e) {
                // Hindari klik pada tombol, link, atau elemen di dalam modal
                if (
                    e.target.tagName === 'BUTTON' ||
                    e.target.closest('button') ||
                    e.target.closest('.modal') ||
                    e.target.tagName === 'A' ||
                    e.target.closest('a') ||
                    e.target.closest('form')
                ) return;
                window.location = this.dataset.url;
            });
        });

        // Scroll ke baris yang di-highlight
        var highlighted = document.querySelector('.highlight-outline');
        if (highlighted) {
            highlighted.scrollIntoView({behavior: "smooth", block: "center"});
        }

        // Script agar tab tetap aktif setelah reload (paginasi)
        var hash = window.location.hash;
        if (hash) {
            var tabTrigger = document.querySelector('a[href="' + hash + '"]');
            if (tabTrigger) {
                var tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }
        // Update hash saat tab diklik
        document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function (e) {
                history.replaceState(null, null, e.target.getAttribute('href'));
            });
        });

        // Tambahkan hash pada link paginasi sesuai tab aktif
        document.querySelectorAll('.pagination a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var activeTab = document.querySelector('.tab-pane.active.show');
                var hash = activeTab ? '#' + activeTab.id : '';
                if (hash && !this.href.includes(hash)) {
                    this.href += hash;
                }
            });
        });
    });
</script>
@endpush
