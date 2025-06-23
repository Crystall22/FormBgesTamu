@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <a href="javascript:history.back()" style="text-decoration: none; color: inherit;">
            <h1>Peminjaman Mobil</h1>
        </a>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('parkings.borrow') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Pilih Mobil</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id" required onchange="showSlotInfo(this)">
                        <option value="">-- Pilih Mobil --</option>
                        @foreach($availableCars as $car)
                            <option value="{{ $car->id }}" data-slot="{{ $car->slot }}">
                                {{ $car->vehicle_name }} - {{ $car->license_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="borrower_name" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="borrower_name" name="borrower_name" required>
                </div>
                <div class="mb-3">
                    <label for="borrower_position" class="form-label">Jabatan Peminjam</label>
                    <select class="form-control" id="borrower_position" name="borrower_position" onchange="toggleCustomPosition(this)" required>
                        <option value="" disabled selected>-- Pilih Jabatan --</option>
                        <option value="Manager">Manager</option>
                        <option value="Assistant Manager">Assistant Manager</option>
                        <option value="Staff">Staff</option>
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" class="form-control mt-2" id="custom_position" name="custom_borrower_position" style="display: none;" placeholder="Masukkan jabatan lain">
                </div>
                <div class="mb-3">
                    <label for="purpose" class="form-label">Tujuan Peminjaman</label>
                    <input type="text" class="form-control" id="purpose" name="purpose" required>
                </div>
                <button type="submit" class="btn btn-success">Pinjam Mobil</button>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm" style="position:sticky; top:90px;">
                <div class="card-body text-center">
                    <div class="fw-bold mb-2">Slot Parkir Saat Ini</div>
                    <div id="slot-value" class="display-4 text-primary" style="font-weight: bold;">-</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleCustomPosition(select) {
        var customPositionInput = document.getElementById('custom_position');
        if (select.value === 'Other') {
            customPositionInput.style.display = 'block';
            customPositionInput.value = '';
        } else {
            customPositionInput.style.display = 'none';
            customPositionInput.value = select.value;
        }
    }

    function showSlotInfo(select) {
        var selected = select.options[select.selectedIndex];
        var slot = selected.getAttribute('data-slot');
        var slotValue = document.getElementById('slot-value');
        if (slot && slot !== "null") {
            slotValue.textContent = slot;
        } else {
            slotValue.textContent = '-';
        }
    }

    // Tampilkan slot parkir jika sudah ada value terpilih (saat validasi gagal)
    document.addEventListener('DOMContentLoaded', function () {
        var select = document.getElementById('vehicle_id');
        if (select.value) {
            showSlotInfo(select);
        }
    });
</script>
@endsection
