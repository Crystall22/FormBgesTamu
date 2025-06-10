@extends('layouts.app')

@section('content')
<div class="page-inner py-4">
    <div class="mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fas fa-user-plus text-primary me-2"></i>
            Tambah User
        </h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                        <option value="secretary" {{ old('role') == 'secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="management-business" {{ old('role') == 'management-business' ? 'selected' : '' }}>Management - Business</option>
                        <option value="management-government" {{ old('role') == 'management-government' ? 'selected' : '' }}>Management - Government</option>
                        <option value="management-enterprise" {{ old('role') == 'management-enterprise' ? 'selected' : '' }}>Management - Enterprise</option>
                        <option value="security" {{ old('role') == 'security' ? 'selected' : '' }}>Security</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
