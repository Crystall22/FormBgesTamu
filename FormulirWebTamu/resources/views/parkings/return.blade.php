@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pengembalian Mobil</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parkings.return') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Pilih Mobil (Vacant)</label>
            <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                <option value="">-- Pilih Mobil --</option>
                @foreach($vacantCars as $car)
                    <option value="{{ $car->id }}">
                        {{ $car->vehicle_name }} - {{ $car->license_number }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="slot" class="form-label">Nomor Slot Parkir Baru</label>
            <input type="number" class="form-control" id="slot" name="slot" min="1" required>
            <small class="text-muted">Tidak boleh sama dengan slot parkir mobil lain.</small>
        </div>
        <button type="submit" class="btn btn-primary">Kembalikan Mobil</button>
    </form>
</div>
@endsection
