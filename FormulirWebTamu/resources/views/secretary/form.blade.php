{{-- filepath: resources/views/secretary/form.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container page-inner">
    <!-- Back Button -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">
            <i class="fas fa-file-alt text-primary me-2"></i>
            Form Details
        </h4>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Go Back
        </a>
    </div>

    {{-- Guest Information Card --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-user-circle fa-2x me-3"></i>
            <div>
                <div class="fw-bold">{{ $form->guest_name }}</div>
                <small>{{ $form->institution }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <p class="mb-2">
                        <i class="fas fa-phone-alt text-info me-1"></i>
                        <span class="fw-semibold">Phone:</span>
                        <span class="text-muted">{{ $form->guest_phone }}</span>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                        <span class="fw-semibold">Address:</span>
                        <span class="text-muted">{{ $form->guest_address }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2">
                        <i class="fas fa-user-check text-success me-1"></i>
                        <span class="fw-semibold">Taken By:</span>
                        <span class="text-muted">{{ $form->taken }}</span>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-calendar-alt text-warning me-1"></i>
                        <span class="fw-semibold">Created:</span>
                        <span class="text-muted">{{ $form->created_at ? $form->created_at->format('d-m-Y H:i') : '-' }}</span>
                    </p>
                </div>
            </div>
            <div class="mb-2">
                <i class="fas fa-bullseye text-secondary me-1"></i>
                <span class="fw-semibold">Purpose:</span>
                <span class="text-muted">{{ $form->purpose }}</span>
            </div>
            <div class="d-flex gap-2 mt-4">
                <a href="{{ asset('storage/' . $form->pdf_file) }}" target="_blank" class="btn btn-info btn-sm">
                    <i class="fas fa-file-pdf me-1"></i> View PDF
                </a>
                <a href="{{ route('secretary.download.pdf', ['id' => $form->id]) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Note and Forward Form --}}
    <form action="{{ route('secretary.update', $form->id) }}" method="POST">
        @csrf
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <i class="fas fa-sticky-note me-2"></i>
                Add Note & Forward to Management
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="note" class="form-label fw-semibold">
                        <i class="fas fa-comment-dots me-1 text-primary"></i>Note
                    </label>
                    <textarea name="note" id="note" class="form-control" rows="4" required>{{ old('note', $form->note ?? '') }}</textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="management_type" class="form-label fw-semibold">
                        <i class="fas fa-share-square me-1 text-success"></i>Forward To Management
                    </label>
                    <select name="management_type" id="management_type" class="form-select" required>
                        <option value="" disabled selected>Select Management</option>
                        <option value="business" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'business') ? 'selected' : '' }}>Business</option>
                        <option value="government" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'government') ? 'selected' : '' }}>Government</option>
                        <option value="enterprise" {{ (old('management_type', $form->forwarded_to_management_type ?? '') == 'enterprise') ? 'selected' : '' }}>Enterprise</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-paper-plane me-2"></i> Forward to Management
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
