@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center bubble-shadow-small">
                                <i class="fas fa-key"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <h4 class="card-title fw-bold text-white">Ubah Password</h4>
                                <p class="card-category text-white">Pastikan untuk memasukkan password lama dan password baru.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-body bg-light">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-bold">Password Lama</label>
                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control rounded-pill" required>
                                <span class="input-group-text bg-white border-0 rounded-pill-end" onclick="togglePasswordVisibility('current_password')">
                                    <i class="fas fa-eye-slash" id="current_password_icon"></i>
                                </span>
                            </div>
                            @if ($errors->has('current_password'))
                                <div class="text-danger small mt-2">{{ $errors->first('current_password') }}</div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="form-label fw-bold">Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control rounded-pill" required>
                                <span class="input-group-text bg-white border-0 rounded-pill-end" onclick="togglePasswordVisibility('new_password')">
                                    <i class="fas fa-eye-slash" id="new_password_icon"></i>
                                </span>
                            </div>
                            @if ($errors->has('new_password'))
                                <div class="text-danger small mt-2">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-pill" required>
                                <span class="input-group-text bg-white border-0 rounded-pill-end" onclick="togglePasswordVisibility('new_password_confirmation')">
                                    <i class="fas fa-eye-slash" id="new_password_confirmation_icon"></i>
                                </span>
                            </div>
                            @if ($errors->has('new_password_confirmation'))
                                <div class="text-danger small mt-2">{{ $errors->first('new_password_confirmation') }}</div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill">
                                <i class="fas fa-save"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('profile') }}" class="btn btn-secondary rounded-pill">
                        <i class="fas fa-arrow-left"></i> Kembali ke Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(`${inputId}_icon`);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endpush
@endsection
