{{-- filepath: resources/views/secretary/dashboard.blade.php --}}
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
        <div class="d-flex justify-content-center mt-5">
            {{ $forms->links('layouts.pagination') }}
        </div>
    @endif
</div>
@endsection
