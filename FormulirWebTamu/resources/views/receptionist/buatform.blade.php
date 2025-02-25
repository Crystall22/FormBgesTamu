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

    <!-- Go to Dashboard Button -->
    <div class="text-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-primary px-5 py-3">
            Go to Dashboard
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h4 class="card-title mb-4 text-primary">Guest Information</h4>
            <form action="{{ route('receptionist.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-4">
                    <label for="guest_name" class="font-weight-bold">Guest Name</label>
                    <input type="text" class="form-control form-control-lg" id="guest_name" name="guest_name" placeholder="Masukkan Nama Anda" required>
                </div>

                <div class="form-group mb-4">
                    <label for="guest_phone" class="font-weight-bold">Phone Number</label>
                    <input type="text" class="form-control form-control-lg" id="guest_phone" name="guest_phone" placeholder="Masukkan Nomor Anda" required>
                </div>

                <div class="form-group mb-4">
                    <label for="guest_address" class="font-weight-bold">Guest Address</label>
                    <input type="text" class="form-control form-control-lg" id="guest_address" name="guest_address" placeholder="Masukkan Alamat Anda" required>
                </div>

                <div class="form-group mb-4">
                    <label for="institution" class="font-weight-bold">Institution</label>
                    <input type="text" class="form-control form-control-lg" id="institution" name="institution" placeholder="Masukkan Institusi Anda" required>
                </div>

                <div class="form-group mb-4">
                    <label for="purpose" class="font-weight-bold">Purpose</label>
                    <textarea class="form-control form-control-lg" id="purpose" name="purpose" placeholder="Masukkan tujuan kunjungan" rows="3" required></textarea>
                </div>

                <div class="form-group mb-4">
                    <label for="pdf_file" class="font-weight-bold">Upload PDF</label>
                    <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                </div>

                <div class="form-group mb-4">
                    <label for="category" class="font-weight-bold">Category</label>
                    <select class="form-control form-control-lg" id="category" name="category" required>
                        <option value="Business">Business</option>
                        <option value="Government">Government</option>
                        <option value="Enterprise">Enterprise</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
