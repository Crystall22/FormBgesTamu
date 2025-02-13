@extends('layouts.app')

@section('header', 'Management Dashboard')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="managementTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="under-review-tab" data-toggle="tab" href="#underReview" role="tab" aria-controls="underReview" aria-selected="true">
                <i class="fas fa-tasks"></i> Under Review
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">
                <i class="fas fa-history"></i> History
            </a>
        </li>
    </ul>

    <div class="tab-content" id="managementTabsContent">
        <!-- Under Review Tab -->
        <div class="tab-pane fade show active" id="underReview" role="tabpanel" aria-labelledby="under-review-tab">
            <h1 class="mb-4 text-primary"><i class="fas fa-file-alt"></i> Forms Under Review</h1>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Guest Name</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Category</th>
                            <th>Note</th>
                            <th>Actions</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsUnderReview as $form)
                            <tr>
                                <td>{{ $form->guest_name }}</td>
                                <td>{{ $form->guest_phone }}</td>
                                <td>{{ $form->institution }}</td>
                                <td>{{ $form->category }}</td>
                                <td>{{ $form->note }}</td>
                                <td>
                                    <form action="{{ route('management.approve', $form->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('management.reject', $form->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                                <td><a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i> View Pdf</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No forms available for review.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- History Tab -->
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <h3 class="mb-4 text-primary"><i class="fas fa-history"></i> History of Accepted and Rejected Forms</h3>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Guest Name</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Category</th>
                            <th>Invoice Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formsHistory as $form)
                            <tr>
                                <td>{{ $form->guest_name }}</td>
                                <td>{{ $form->guest_phone }}</td>
                                <td>{{ $form->institution }}</td>
                                <td>{{ $form->category }}</td>
                                <td>{{ $form->invoice_number }}</td>
                                <td>
                                    @if ($form->status === 'approved')
                                        <span class="badge badge-success">Accepted</span>
                                    @elseif ($form->status === 'rejected')
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No form history available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
