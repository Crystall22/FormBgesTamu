@extends('layouts.app')

@section('content')
<div class="container">
    <header class="d-flex justify-content-between align-items-center">
        <a href="javascript:history.back()" style="text-decoration: none; color: inherit;">
            <h1>Add New Parking</h1>
        </a>
    </header>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('parkings.store') }}" method="POST">
        @csrf

        <fieldset class="form-group">
            <label for="vehicle_name">Vehicle Name</label>
            <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" required placeholder="Masukkan nama kendaraan">
        </fieldset>

        <fieldset class="form-group">
            <label for="license_number">License Number</label>
            <input type="text" class="form-control" id="license_number" name="license_number" required
                   pattern="[A-Za-z]{1,2}\d{1,4}[A-Za-z]{0,4}"
                   title="Nomor Polisi Harus Mengikuti Standar e.g(BG1111AA)" placeholder="Masukkan nomor polisi">
        </fieldset>

        <fieldset class="form-group">
            <label for="slot">Slot Parkir</label>
            <input type="number" class="form-control" id="slot" name="slot" required min="1" placeholder="Masukkan nomor slot parkir">
        </fieldset>

        <button type="submit" class="btn btn-success">Add Parking</button>
    </form>
</div>
@endsection
