@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Gradient Header with Seamless Button -->
        <div class="gradient-header rounded-3 shadow-lg p-4 mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="dashboard-link btn btn-transparent shadow-none p-2" title="Go to Dashboard">
                    <i class="bi bi-arrow-left-circle-fill fs-3 text-light"></i>
                </a>
                <h1 class="fs-2 fw-bold m-0 flex-grow-1 text-center">Secretary Dashboard</h1>
                <div style="width: 36px;"></div> <!-- Spacer -->
            </div>
        </div>

        <!-- Compact Cards for Forms -->
        <div class="row g-4">
            @forelse ($forms as $form)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 rounded-3 shadow-lg">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3 fw-semibold">{{ $form->guest_name ?? 'N/A' }}</h5>
                            <p class="card-text mb-2">
                                <strong>Institution:</strong> {{ $form->institution ?? 'N/A' }}
                            </p>
                            <p class="card-text mb-4">
                                <strong>Taken By:</strong> {{ $form->taken ?? 'N/A' }}
                            </p>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('secretary.form', $form->id) }}" class="btn btn-primary btn-sm px-4 py-2 shadow-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 rounded-3 shadow-lg">
                        <div class="card-body text-center p-5">
                            <h5 class="fw-semibold">No Forms Available</h5>
                            <p class="text-muted">There are currently no forms to display.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        {{-- @if ($forms->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $forms->links('layouts.pagination') }}
            </div>
        @endif
    </div> --}}
@endsection
