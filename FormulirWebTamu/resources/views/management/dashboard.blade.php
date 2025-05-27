@extends('layouts.app')

@section('header', 'Management Dashboard')

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

        <!-- Dashboard Button -->
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
            <i class="fas fa-house"></i>
        </a>
    </div>

    <div class="tab-content" id="managementTabsContent">
        <!-- Under Review Tab -->
        <div class="tab-pane fade show active" id="underReview" role="tabpanel" aria-labelledby="under-review-tab">
            <h3 class="mb-4"><i class="fas fa-file-alt"></i> Forms Under Review</h3>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle custom-table">
                    <thead>
                        <tr class="text-center custom-table-header">
                            <th>Guest Name</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Taken</th>
                            <th>Note</th>
                            <th>Actions</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsUnderReview as $form)
                            <tr class="text-center">
                                <td>{{ $form->guest_name ?? 'N/A' }}</td>
                                <td>{{ $form->guest_phone ?? 'N/A' }}</td>
                                <td>{{ $form->institution ?? 'N/A' }}</td>
                                <td>{{ $form->taken ?? 'N/A' }}</td>
                                <td>{{ $form->note ?? 'N/A' }}</td>
                                <td class="d-flex justify-content-center">
                                    <form action="{{ route('management.approve', $form->id) }}" method="POST" class="mr-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success px-3 py-1">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('management.reject', $form->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 py-1">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-sm btn-primary px-3 py-1">
                                        <i class="fas fa-file-pdf"></i> View Pdf
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-warning">No forms available for review.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- History Tab -->
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <h3 class="mb-4"><i class="fas fa-history"></i> History of Accepted and Rejected Forms</h3>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle custom-table">
                    <thead>
                        <tr class="text-center custom-table-header">
                            <th>Guest Name</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Taken</th>
                            <th>Invoice Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsHistory as $form)
                            <tr class="text-center">
                                <td>{{ $form->guest_name ?? 'N/A' }}</td>
                                <td>{{ $form->guest_phone ?? 'N/A' }}</td>
                                <td>{{ $form->institution ?? 'N/A' }}</td>
                                <td>{{ $form->taken ?? 'N/A' }}</td>
                                <td>{{ $form->invoice_number ?? 'N/A' }}</td>
                                <td>
                                    @if ($form->status === 'approved')
                                        <span class="badge bg-success text-white">Accepted</span>
                                    @elseif ($form->status === 'rejected')
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-warning">No form history available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
