{{-- filepath: resources/views/receptionist/qr-detail.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <h3 class="mb-3 text-primary fw-bold">QR Code Formulir</h3>
                    <div class="mb-4">
                        @if($form->qr_code)
                            <div class="d-flex justify-content-center align-items-center" style="min-height:220px;">
                                {!! Storage::disk('public')->get($form->qr_code) !!}
                            </div>
                            <div class="mt-3 d-flex justify-content-center gap-2">
                                <a href="{{ route('form.downloadQr', $form->id) }}" class="btn btn-outline-success">
                                    <i class="fa fa-download me-1"></i> Download QR
                                </a>
                                <button class="btn btn-outline-info" onclick="shareQrLink()">
                                    <i class="fa fa-share-alt me-1"></i> Share Link
                                </button>
                            </div>
                            <input type="text" id="qr-share-link" class="form-control mt-2 text-center" value="{{ route('form.detail', $form->id) }}" readonly style="display:none;">
                        @else
                            <div class="alert alert-warning">QR Code tidak tersedia.</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1">{{ $form->guest_name }}</h5>
                        <div class="text-muted mb-2">{{ $form->institution }}</div>
                        <div class="small text-muted">No. Invoice: {{ $form->invoice_number }}</div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function shareQrLink() {
    var input = document.getElementById('qr-share-link');
    input.style.display = 'block';
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');
    alert('Link QR telah disalin:\n' + input.value);
}
</script>
@endsection
