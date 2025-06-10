@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="d-flex align-items-center gap-4 mb-4">
                <div class="bg-white rounded-circle shadow d-flex align-items-center justify-content-center" style="width:90px; height:90px;">
                    <i class="fa fa-user-circle fa-4x text-primary"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold text-primary">{{ $form->guest_name }}</h2>
                    <div class="text-muted mb-1">
                        <i class="fa fa-calendar-alt me-1"></i> {{ $form->created_at->format('d-m-Y H:i') }}
                        <span class="mx-2">|</span>
                        <i class="fa fa-building me-1"></i> {{ $form->institution }}
                    </div>
                    <span class="badge
                        @if($form->status === 'approved') bg-success
                        @elseif($form->status === 'rejected') bg-danger
                        @else bg-warning text-dark @endif
                        px-3 py-2 fs-6">
                        @if($form->status === 'approved')
                            <i class="fas fa-check-circle me-1"></i>Accepted
                        @elseif($form->status === 'rejected')
                            <i class="fas fa-times-circle me-1"></i>Rejected
                        @else
                            <i class="fas fa-hourglass-half me-1"></i>Under Review
                        @endif
                    </span>
                </div>
                @if($form->qr_code)
                <div class="ms-auto text-center">
                    <img src="{{ asset('storage/' . $form->qr_code) }}" alt="QR Code" width="100" class="rounded shadow border bg-white p-2">
                    <div class="small text-muted mt-2">Scan untuk cek status</div>
                </div>
                @endif
            </div>

            <!-- Info Grid -->
            <div class="row g-0">
                <div class="col-md-7 pe-md-5 border-end">
                    <div class="mb-3">
                        <span class="fw-semibold text-primary"><i class="fa fa-info-circle me-2"></i>Informasi Tamu</span>
                    </div>
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted"><i class="fa fa-phone me-2 text-info"></i>No HP</dt>
                        <dd class="col-sm-8 mb-2">{{ $form->guest_phone }}</dd>

                        <dt class="col-sm-4 text-muted"><i class="fa fa-map-marker-alt me-2 text-success"></i>Alamat</dt>
                        <dd class="col-sm-8 mb-2">{{ $form->guest_address }}</dd>

                        <dt class="col-sm-4 text-muted"><i class="fa fa-user-tie me-2 text-secondary"></i>Petugas</dt>
                        <dd class="col-sm-8 mb-2">{{ $form->taken }}</dd>

                        <dt class="col-sm-4 text-muted"><i class="fa fa-file-invoice me-2 text-dark"></i>No. Invoice</dt>
                        <dd class="col-sm-8 mb-2">{{ $form->invoice_number }}</dd>
                    </dl>
                </div>
                <div class="col-md-5 ps-md-5 mt-4 mt-md-0">
                    <div class="mb-3">
                        <span class="fw-semibold text-primary"><i class="fa fa-clipboard-list me-2"></i>Status &amp; Catatan</span>
                    </div>
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted"><i class="fa fa-sticky-note me-2 text-warning"></i>Tujuan</dt>
                        <dd class="col-sm-7 mb-2">{{ $form->purpose }}</dd>

                        <dt class="col-sm-5 text-muted"><i class="fa fa-calendar-check me-2 text-success"></i>Tanggal</dt>
                        <dd class="col-sm-7 mb-2">{{ $form->created_at->format('d-m-Y H:i') }}</dd>

                        @if($form->pdf_file)
                        <dt class="col-sm-5 text-muted"><i class="fa fa-file-pdf me-2 text-danger"></i>PDF</dt>
                        <dd class="col-sm-7 mb-2">
                            <a href="{{ asset('storage/'.$form->pdf_file) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-file-pdf"></i> Lihat PDF
                            </a>
                        </dd>
                        @endif
                    </dl>
                    @if($form->status === 'rejected')
                        <div class="alert alert-danger mt-4 d-flex align-items-center">
                            <i class="fa fa-comment-dots fa-lg me-2"></i>
                            <div>
                                <b>Alasan Penolakan:</b><br>
                                {{ $form->reject_reason }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-4 d-flex align-items-center">
                            <i class="fa fa-info-circle fa-lg me-2"></i>
                            <div>
                                <b>Status Form:</b>
                                @if($form->status === 'approved')
                                    Diterima.
                                @elseif($form->status === 'rejected')
                                    Ditolak.
                                @else
                                    Menunggu review.
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
