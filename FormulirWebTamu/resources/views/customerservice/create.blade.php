@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-plus text-primary me-2"></i> Tambah Data Modem
        </div>
        <div class="card-body">
            {{-- Tampilkan error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="modemForm" action="{{ route('customerservice.modem.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" id="tanggal_terima"
                        class="form-control @error('tanggal_terima') is-invalid @enderror"
                        required value="{{ old('tanggal_terima') }}">
                </div>
                <div class="mb-3">
                    <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                        class="form-control @error('tanggal_keluar') is-invalid @enderror"
                        value="{{ old('tanggal_keluar') }}">
                </div>
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                    <input type="text" name="id_pelanggan" id="id_pelanggan"
                        class="form-control @error('id_pelanggan') is-invalid @enderror"
                        required value="{{ old('id_pelanggan') }}">
                </div>
                <div class="mb-3">
                    <label for="provider_modem" class="form-label">Provider Modem</label>
                    <select name="provider_modem" id="provider_modem"
                        class="form-select @error('provider_modem') is-invalid @enderror" required>
                        <option value="" disabled {{ old('provider_modem') ? '' : 'selected' }}>Pilih Provider</option>
                        <option value="huawei" {{ old('provider_modem') == 'huawei' ? 'selected' : '' }}>Huawei</option>
                        <option value="zte" {{ old('provider_modem') == 'zte' ? 'selected' : '' }}>ZTE</option>
                        <option value="fiberhome" {{ old('provider_modem') == 'fiberhome' ? 'selected' : '' }}>Fiberhome</option>
                        <option value="other" {{ old('provider_modem') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="mb-3 {{ old('provider_modem') == 'other' ? '' : 'd-none' }}" id="manual_provider_container">
                    <label for="manual_provider" class="form-label">Nama Provider</label>
                    <input type="text" name="manual_provider" id="manual_provider"
                        class="form-control @error('manual_provider') is-invalid @enderror"
                        value="{{ old('manual_provider') }}">
                </div>
                <div class="mb-3 {{ old('provider_modem') ? '' : 'd-none' }}" id="serial_number_container">
                    <label for="serial_number_modem" class="form-label">Serial Number Modem</label>
                    <input type="text" name="serial_number_modem" id="serial_number_modem"
                        class="form-control @error('serial_number_modem') is-invalid @enderror"
                        value="{{ old('serial_number_modem') }}">
                </div>
                <div class="mb-3">
                    <label for="stb_id" class="form-label">Set Top Box ID</label>
                    <input type="text" name="stb_id" id="stb_id"
                        class="form-control @error('stb_id') is-invalid @enderror"
                        maxlength="16" required value="{{ old('stb_id') }}">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4" id="btnSimpan">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const providerSelect = document.getElementById('provider_modem');
        const serialContainer = document.getElementById('serial_number_container');
        const serialInput = document.getElementById('serial_number_modem');
        const manualProviderContainer = document.getElementById('manual_provider_container');
        const form = document.getElementById('modemForm');

        // Set initial state for manual provider & serial number
        function updateProviderFields() {
            const provider = providerSelect.value;
            if (provider) {
                serialContainer.classList.remove('d-none');
            } else {
                serialContainer.classList.add('d-none');
            }
            if (provider === 'other') {
                manualProviderContainer.classList.remove('d-none');
                serialInput.maxLength = 18;
                serialInput.placeholder = 'Masukkan maksimal 18 digit';
            } else {
                manualProviderContainer.classList.add('d-none');
                if (provider === 'huawei') {
                    serialInput.maxLength = 16;
                    serialInput.placeholder = 'Masukkan 16 digit';
                } else if (provider === 'zte' || provider === 'fiberhome') {
                    serialInput.maxLength = 12;
                    serialInput.placeholder = 'Masukkan 12 digit';
                }
            }
        }
        providerSelect.addEventListener('change', updateProviderFields);
        updateProviderFields();

        // SweetAlert konfirmasi sebelum submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
