@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header Banner -->
    {{-- Uncomment this if you want to display a banner
    <div class="jumbotron bg-primary text-white text-center py-5 mb-4">
        <h1 class="display-4">Create Guest Form</h1>
        <p class="lead">Fill in the form to register a guest for the meeting.</p>
    </div>
    --}}

    <!-- Form -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title mb-4">Guest Information</h2>
            <form action="{{ route('receptionist.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="guest_name">Guest Name</label>
                    <input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Masukkan Nama Anda" required>
                </div>

                <div class="form-group mb-3">
                    <label for="guest_phone">Phone Number</label>
                    <input type="text" class="form-control" id="guest_phone" name="guest_phone" placeholder="Masukkan Nomor Anda" required>
                </div>

                <div class="form-group mb-3">
                    <label for="guest_address">Guest Address</label>
                    <input type="text" class="form-control" id="guest_address" name="guest_address" placeholder="Masukkan Alamat Anda" required>
                </div>

                <div class="form-group mb-3">
                    <label for="institution">Institution</label>
                    <input type="text" class="form-control" id="institution" name="institution" placeholder="Masukkan Institusi Anda" required>
                </div>

                <div class="form-group mb-3">
                    <label for="purpose">Tujuan</label>
                    <textarea class="form-control" id="purpose" name="purpose" placeholder="Masukkan tujuan kunjungan" rows="3" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="pdf_file">Upload PDF</label>
                    <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                </div>

                <div class="form-group mb-3">
                    <label for="category">Kategori Tujuan</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="Business">Business</option>
                        <option value="Government">Government</option>
                        <option value="Enterprise">Enterprise</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
