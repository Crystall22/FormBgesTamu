@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-header">
            <div class="card-title fw-bold">Guest Information</div>
        </div>
        <div class="card-body">
            <form action="{{ route('receptionist.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guest_name">Guest Name</label>
                            <input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Masukkan Nama Anda" maxlength="75" required>
                        </div>
                        <div class="form-group">
                            <label for="guest_phone">Phone Number</label>
                            <input type="tel" class="form-control" id="guest_phone" name="guest_phone" placeholder="Masukkan Nomor Anda" maxlength="14" pattern="[0-9]{10,14}" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                        <div class="form-group">
                            <label for="guest_address">Guest Address</label>
                            <input type="text" class="form-control" id="guest_address" name="guest_address" placeholder="Masukkan Alamat Anda" maxlength="200" required>
                        </div>
                        <div class="form-group">
                            <label for="institution">Institution</label>
                            <input type="text" class="form-control" id="institution" name="institution" placeholder="Masukkan Institusi Anda" maxlength="100" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Masukkan tujuan kunjungan" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pdf_file">Upload PDF</label>
                            <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                        </div>
                        <div class="form-group">
                            <label for="taken">Taken By</label>
                            <select class="form-select" id="taken" name="taken" required>
                                <option value="Sule">Sule</option>
                                <option value="Ardi">Ardi</option>
                                <option value="Hutri">Hutri</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
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
