@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-phone-alt text-primary me-2"></i>
            Tambah Data Panggilan Call Center
        </h3>
        <div>
            <a href="{{ route('customerservice.call-center.index') }}" class="btn btn-secondary btn-sm px-3 py-2 shadow-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('customerservice.call-center.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @if ($errors->has('name'))
                            <div class="text-danger small mt-2">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="phone_number" class="form-label">Nomor Ponsel</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" pattern="[0-9]+" title="Hanya angka" required>
                        @if ($errors->has('phone_number'))
                            <div class="text-danger small mt-2">{{ $errors->first('phone_number') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="connection_type" class="form-label">Nomor Internet/Telepon Rumah</label>
                        <input type="text" name="connection_type" id="connection_type" class="form-control" pattern="[0-9]+" title="Hanya angka" required>
                        @if ($errors->has('connection_type'))
                            <div class="text-danger small mt-2">{{ $errors->first('connection_type') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category" class="form-label">Kategori Keperluan</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <option value="Informasi">Informasi</option>
                            <option value="Gangguan">Gangguan</option>
                            <option value="Berhenti Langganan">Berhenti Langganan</option>
                            <option value="Ganti Paket">Ganti Paket</option>
                            <option value="Pasang Baru">Pasang Baru</option>
                            <option value="Complain">Complain</option>
                        </select>
                        @if ($errors->has('category'))
                            <div class="text-danger small mt-2">{{ $errors->first('category') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="purpose" class="form-label">Keperluan</label>
                        <input type="text" name="purpose" id="purpose" class="form-control" required>
                        @if ($errors->has('purpose'))
                            <div class="text-danger small mt-2">{{ $errors->first('purpose') }}</div>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
