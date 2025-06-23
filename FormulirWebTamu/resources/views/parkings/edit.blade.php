@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">
            <i class="fas fa-edit text-primary me-2"></i> Edit Data Modem
        </div>
        <div class="card-body">
            <form id="modemForm" action="{{ route('customerservice.modem.update', $modem->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                    <input type="date" name="tanggal_terima" id="tanggal_terima" class="form-control" value="{{ $modem->tanggal_terima }}" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ $modem->tanggal_keluar }}">
                </div>
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
                    <input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control" value="{{ $modem->id_pelanggan }}" required>
                </div>
                <div class="mb-3">
                    <label for="provider_modem" class="form-label">Provider Modem</label>
                    <select name="provider_modem" id="provider_modem" class="form-select" required>
                        <option value="" disabled>Pilih Provider</option>
                        <option value="huawei" {{ $modem->provider_modem == 'huawei' ? 'selected' : '' }}>Huawei</option>
                        <option value="zte" {{ $modem->provider_modem == 'zte' ? 'selected' : '' }}>ZTE</option>
                        <option value="fiberhome" {{ $modem->provider_modem == 'fiberhome' ? 'selected' : '' }}>Fiberhome</option>
                        <option value="other" {{ $modem->provider_modem == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="mb-3 d-none" id="manual_provider_container">
                    <label for="manual_provider" class="form-label">Nama Provider</label>
                    <input type="text" name="manual_provider" id="manual_provider" class="form-control" value="{{ $modem->provider_modem == 'other' ? $modem->manual_provider : '' }}">
                </div>
                <div class="mb-3 d-none" id="serial_number_container">
                    <label for="serial_number_modem" class="form-label">Serial Number Modem</label>
                    <input type="text" name="serial_number_modem" id="serial_number_modem" class="form-control" value="{{ $modem->serial_number_modem }}" required>
                </div>
                <div class="mb-3">
                    <label for="stb_id" class="form-label">Set Top Box ID</label>
                    <input type="text" name="stb_id" id="stb_id" class="form-control" value="{{ $modem->stb_id }}" maxlength="16" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Update
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
<!-- SweetAlert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const providerSelect = document.getElementById('provider_modem');
        const serialContainer = document.getElementById('serial_number_container');
        const serialInput = document.getElementById('serial_number_modem');
        const manualProviderContainer = document.getElementById('manual_provider_container');
        const modemForm = document.getElementById('modemForm');

        // Dynamic field handling
        providerSelect.addEventListener('change', function () {
            const provider = this.value;
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
        });

        // Initialize dynamic fields based on current value
        if (providerSelect.value) {
            serialContainer.classList.remove('d-none');
            if (providerSelect.value === 'other') {
                manualProviderContainer.classList.remove('d-none');
                serialInput.maxLength = 18;
                serialInput.placeholder = 'Masukkan maksimal 18 digit';
            } else if (providerSelect.value === 'huawei') {
                serialInput.maxLength = 16;
                serialInput.placeholder = 'Masukkan 16 digit';
            } else if (providerSelect.value === 'zte' || providerSelect.value === 'fiberhome') {
                serialInput.maxLength = 12;
                serialInput.placeholder = 'Masukkan 12 digit';
            }
        }

        // Handle form submission with SweetAlert
        modemForm.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch(modemForm.action, {
                method: 'POST',
                body: new FormData(modemForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    swal({
                        title: "Berhasil!",
                        text: data.message || "Data modem berhasil diupdate.",
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "OK",
                                className: "btn btn-success"
                            }
                        }
                    }).then(() => {
                        window.location.href = "{{ route('customerservice.modem.index') }}";
                    });
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message || "Terjadi kesalahan saat memperbarui data.",
                        icon: "error",
                        buttons: {
                            confirm: {
                                text: "OK",
                                className: "btn btn-danger"
                            }
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal({
                    title: "Error!",
                    text: "Terjadi kesalahan jaringan atau server. Silakan coba lagi.",
                    icon: "error",
                    buttons: {
                        confirm: {
                            text: "OK",
                            className: "btn btn-danger"
                        }
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
