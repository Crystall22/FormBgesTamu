<div class="row g-4" id="history-list">
    @forelse ($history as $form)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 rounded-3 shadow-lg position-relative">
                <span class="badge bg-info position-absolute top-0 end-0 m-3" style="z-index:2;">
                    {{ ucfirst($form->forwarded_to_management_type ?? '-') }}
                </span>
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
                        <a href="{{ route('secretary.form', $form->id) }}?readonly=1" class="btn btn-primary btn-sm px-4 py-2 shadow-sm">
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
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5 class="fw-semibold">No History Available</h5>
                    <p class="text-muted">There are currently no history records to display.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>
@if (method_exists($history, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $history->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
    </div>
@endif

