@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h2 class="text-lg font-semibold mb-2 mb-md-0">Guest Information</h2>
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">Go to Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('form.deleteScreen') }}" class="nav-link">Go to Delete Form</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Form -->
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <form action="{{ route('receptionist.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Guest Name -->
                <div class="form-group mb-4">
                    <label for="guest_name" class="form-label">Guest Name</label>
                    <input type="text" class="form-control form-control-lg custom-input" id="guest_name" name="guest_name" placeholder="Masukkan Nama Anda" maxlength="75" required>
                </div>

                <!-- Phone Number -->
                <div class="form-group mb-4">
                    <label for="guest_phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control form-control-lg custom-input" id="guest_phone" name="guest_phone" placeholder="Masukkan Nomor Anda" maxlength="14" pattern="[0-9]{10,14}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>

                <!-- Guest Address -->
                <div class="form-group mb-4">
                    <label for="guest_address" class="form-label">Guest Address</label>
                    <input type="text" class="form-control form-control-lg custom-input" id="guest_address" name="guest_address" placeholder="Masukkan Alamat Anda" maxlength="200" required>
                </div>

                <!-- Institution -->
                <div class="form-group mb-4">
                    <label for="institution" class="form-label">Institution</label>
                    <input type="text" class="form-control form-control-lg custom-input" id="institution" name="institution" placeholder="Masukkan Institusi Anda" maxlength="100" required>
                </div>

                <!-- Purpose -->
                <div class="form-group mb-4">
                    <label for="purpose" class="form-label">Purpose</label>
                    <textarea class="form-control form-control-lg custom-input" id="purpose" name="purpose" placeholder="Masukkan tujuan kunjungan" rows="3" required></textarea>
                </div>

                <!-- PDF Upload -->
                <div class="form-group mb-4">
                    <label for="pdf_file" class="form-label">Upload PDF</label>
                    <div class="pdf-upload-container" style="display: flex;">
                        <input type="file" class="pdf-upload-input" id="pdf_file" name="pdf_file" accept=".pdf" style="display: none;" required>
                        <button type="button" class="pdf-upload-btn custom-upload-btn" style="padding: 0.2rem 0.5rem; font-size: 0.9rem; display: inline-block;">
                            <span class="upload-icon">↑</span> Upload
                        </button>
                        <div class="pdf-file-name-wrapper" style="margin-left: 1rem;">
                            <span class="pdf-file-name"></span>
                        </div>
                    </div>
                </div>

                <!-- Taken By -->
                <div class="form-group mb-4">
                    <label for="taken" class="form-label">Taken By</label>
                    <select class="form-control form-control-lg custom-select" id="taken" name="taken" required>
                        <option value="Sule">Sule</option>
                        <option value="Ardi">Ardi</option>
                        <option value="Hutri">Hutri</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg w-100 custom-submit-btn">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pdfInput = document.querySelector('.pdf-upload-input');
        const pdfButton = document.querySelector('.pdf-upload-btn');
        const pdfFileName = document.querySelector('.pdf-file-name');
        pdfButton.addEventListener('click', function () {
            pdfInput.click();
        });

        pdfInput.addEventListener('change', function () {
            if (pdfInput.files.length > 0) {
                const fileName = pdfInput.files[0].name;
                pdfFileName.textContent = fileName.length > 30 ? fileName.substring(0, 30) + '---.pdf' : fileName;
            } else {
                pdfFileName.textContent = '';
            }
        });
    });
</script>
@endsection
