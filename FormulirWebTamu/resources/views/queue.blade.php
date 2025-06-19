@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-ticket-alt text-primary me-2"></i> Ambil Nomor Antrian
        </div>
        <div class="card-body">
            <form action="{{ route('queue.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Nomor Pelanggan</label>
                    <input type="text" name="customer_id" id="customer_id" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-check"></i> Ambil Nomor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
