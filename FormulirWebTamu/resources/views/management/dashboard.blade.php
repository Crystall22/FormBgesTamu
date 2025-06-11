{{-- filepath: resources/views/management/dashboard.blade.php --}}
@extends('layouts.app')

@section('header', ucfirst($type) . ' Management Dashboard')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="managementTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="under-review-tab" data-bs-toggle="tab" href="#underReview" role="tab" aria-controls="underReview" aria-selected="true">
                    <i class="fas fa-tasks"></i> Under Review
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">
                    <i class="fas fa-history"></i> History
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="managementTabsContent">
        <div class="tab-pane fade show active" id="underReview" role="tabpanel" aria-labelledby="under-review-tab">
            <h3 class="mb-4"><i class="fas fa-file-alt"></i> Forms Under Review</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th><i class="fas fa-user"></i> Guest Name</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-building"></i> Institution</th>
                            <th><i class="fas fa-user-check"></i> Taken</th>
                            <th><i class="fas fa-sticky-note"></i> Note</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                            <th><i class="fas fa-file-pdf"></i> PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsUnderReview as $form)
                            <tr class="text-center align-middle">
                                <td>
                                    <i class="fas fa-user text-primary me-1"></i>
                                    {{ $form->guest_name ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-phone text-info me-1"></i>
                                    {{ $form->guest_phone ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-building text-secondary me-1"></i>
                                    {{ $form->institution ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-user-check text-success me-1"></i>
                                    {{ $form->taken ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-sticky-note text-warning me-1"></i>
                                    {{ $form->note ?? 'N/A' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('management.approve', $form->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success px-3 py-1" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <!-- Reject Button triggers modal -->
                                        <button type="button" class="btn btn-sm btn-danger px-3 py-1" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $form->id }}" title="Reject">
                                            <i class="fas fa-times"></i>
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
                                    <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-sm btn-primary px-3 py-1" data-bs-toggle="tooltip" title="View PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-warning">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <div>No forms available for review.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <h3 class="mb-4"><i class="fas fa-history"></i> History of Accepted and Rejected Forms</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
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
                            <tr class="text-center align-middle">
                                <td>
                                    <i class="fas fa-user text-primary me-1"></i>
                                    {{ $form->guest_name ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-phone text-info me-1"></i>
                                    {{ $form->guest_phone ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-building text-secondary me-1"></i>
                                    {{ $form->institution ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-user-check text-success me-1"></i>
                                    {{ $form->taken ?? 'N/A' }}
                                </td>
                                <td>
                                    <i class="fas fa-file-invoice text-info me-1"></i>
                                    {{ $form->invoice_number ?? 'N/A' }}
                                </td>
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
            </div>
        </div>
    </div>
@endsection


