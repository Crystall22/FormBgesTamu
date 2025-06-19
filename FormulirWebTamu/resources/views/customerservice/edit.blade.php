@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-edit text-primary me-2"></i> Edit Data Modem
        </div>
        <div class="card-body">
            <form action="{{ route('customerservice.modem.update', $modem->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" id="tanggal_terima" class="form-control" value="{{ old('tanggal_terima', $modem->tanggal_terima) }}" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar', $modem->tanggal_keluar) }}">
                </div>
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                    <input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control" value="{{ old('id_pelanggan', $modem->id_pelanggan) }}" required>
                </div>
                <div class="mb-3">
                    <label for="provider_modem" class="form-label">Provider Modem</label>
                    <select name="provider_modem" id="provider_modem" class="form-select" required>
                        <option value="huawei" {{ old('provider_modem', $modem->provider_modem) === 'huawei' ? 'selected' : '' }}>Huawei</option>
                        <option value="zte" {{ old('provider_modem', $modem->provider_modem) === 'zte' ? 'selected' : '' }}>ZTE</option>
                        <option value="fiberhome" {{ old('provider_modem', $modem->provider_modem) === 'fiberhome' ? 'selected' : '' }}>Fiberhome</option>
                        <option value="other" {{ old('provider_modem', $modem->provider_modem) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="mb-3 {{ old('provider_modem', $modem->provider_modem) === 'other' ? '' : 'd-none' }}" id="manual_provider_container">
                    <label for="manual_provider" class="form-label">Nama Provider</label>
                    <input type="text" name="manual_provider" id="manual_provider" class="form-control" value="{{ old('manual_provider', $modem->manual_provider) }}">
                </div>
                <div class="mb-3">
                    <label for="serial_number_modem" class="form-label">Serial Number Modem</label>
                    <input type="text" name="serial_number_modem" id="serial_number_modem" class="form-control" value="{{ old('serial_number_modem', $modem->serial_number_modem) }}" required>
                </div>
                <div class="mb-3">
                    <label for="stb_id" class="form-label">Set Top Box ID</label>
                    <input type="text" name="stb_id" id="stb_id" class="form-control" value="{{ old('stb_id', $modem->stb_id) }}" maxlength="16" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('customerservice.modem.index') }}" class="btn btn-secondary ms-2 px-4">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const providerSelect = document.getElementById('provider_modem');
        const manualProviderContainer = document.getElementById('manual_provider_container');

        providerSelect.addEventListener('change', function () {
            const provider = this.value;

            // Tampilkan kolom manual provider jika "Other" dipilih
            if (provider === 'other') {
                manualProviderContainer.classList.remove('d-none');
            } else {
                manualProviderContainer.classList.add('d-none');
            }
        });

        // Trigger change event on page load to set initial visibility
        providerSelect.dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection
