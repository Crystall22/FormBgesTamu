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
    <style>
    h4{
        color: #b61c0f;
    }
    </style>
    <!-- Go to Dashboard Button -->
    <div class="text-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-danger px-5 py-3">
            Go to Dashboard
        </a>
        <a href="{{ route('form.deleteScreen') }}" class="btn btn-lg btn-outline-danger px-5 py-3">
            Go to Delete
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h4 class="card-title mb-4">Guest Information</h4>
            <form action="{{ route('receptionist.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Guest Name -->
                <div class="form-group mb-4">
                    <label for="guest_name" class="font-weight-bold">Guest Name</label>
                    <input type="text" class="form-control form-control-lg" id="guest_name" name="guest_name" placeholder="Masukkan Nama Anda" required>
                </div>

                <!-- Phone Number -->
                <div class="form-group mb-4">
                    <label for="guest_phone" class="font-weight-bold">Phone Number</label>
                    <input type="text" class="form-control form-control-lg" id="guest_phone" name="guest_phone" placeholder="Masukkan Nomor Anda" required>
                </div>

                <!-- Guest Address -->
                <div class="form-group mb-4">
                    <label for="guest_address" class="font-weight-bold">Guest Address</label>
                    <input type="text" class="form-control form-control-lg" id="guest_address" name="guest_address" placeholder="Masukkan Alamat Anda" required>
                </div>

                <!-- Institution -->
                <div class="form-group mb-4">
                    <label for="institution" class="font-weight-bold">Institution</label>
                    <input type="text" class="form-control form-control-lg" id="institution" name="institution" placeholder="Masukkan Institusi Anda" required>
                </div>

                <!-- Purpose -->
                <div class="form-group mb-4">
                    <label for="purpose" class="font-weight-bold">Purpose</label>
                    <textarea class="form-control form-control-lg" id="purpose" name="purpose" placeholder="Masukkan tujuan kunjungan" rows="3" required></textarea>
                </div>

                <!-- Upload PDF -->
                <div class="form-group mb-4">
                    <label for="pdf_file" class="font-weight-bold">Upload PDF</label>
                    <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf" required>
                </div>

                <!-- taken -->
                <div class="form-group mb-4">
                    <label for="taken" class="font-weight-bold">Taken By</label>
                    <select class="form-control form-control-lg" id="taken" name="taken" required>
                        <option value="Sule">Sule</option>
                        <option value="Ardi">Ardi</option>
                        <option value="Hutri">Hutri</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg w-100">Submit</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Responsive form adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px;
        }

        .btn-lg {
            font-size: 1.2rem;
        }

        .form-control-lg {
            font-size: 1rem;
        }
    }

    @media (min-width: 769px) {
        .btn-lg {
            font-size: 1.5rem;
        }

        .form-control-lg {
            font-size: 1.25rem;
        }
    }
</style>

@endsection
